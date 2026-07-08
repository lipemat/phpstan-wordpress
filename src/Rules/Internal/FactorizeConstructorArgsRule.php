<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Internal;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules;
use PHPStan\Rules\Rule;
use PHPStan\Type\VerbosityLevel;

/**
 * Validate the arguments passed to `Factory::factorize()` against the
 * real `__construct()` signature of the class the call resolves to.
 *
 * The `Factory` trait templates the constructor arguments via
 * `@template CONSTRUCT_PARAMS`, which forces every consumer to duplicate
 * its own constructor signature on the `use Factory;` statement. This rule
 * reflects the actual constructor instead, so the template is redundant.
 *
 * @implements Rule<StaticCall>
 */
class FactorizeConstructorArgsRule implements Rule {
	/**
	 * @var string
	 */
	public const FACTORY_TRAIT = 'Lipe\Lib\Container\Factory';

	/**
	 * @var string
	 */
	public const METHOD = 'factorize';

	/**
	 * @var string
	 */
	private $identifier = 'lipemat.factorizeConstructorArgs';


	public function getNodeType(): string {
		return StaticCall::class;
	}


	/**
	 * @phpstan-param StaticCall $node
	 *
	 * @return list<Rules\IdentifierRuleError>
	 */
	public function processNode( Node $node, Scope $scope ): array {
		if ( ! $node->name instanceof Identifier || self::METHOD !== \strtolower( $node->name->name ) ) {
			return [];
		}

		$classReflection = $this->getCalledClass( $node, $scope );
		if ( null === $classReflection || ! $this->usesFactoryTrait( $classReflection ) ) {
			return [];
		}
		if ( ! $classReflection->hasConstructor() ) {
			return [];
		}

		$args = $node->getArgs();
		foreach ( $args as $arg ) {
			// Conservatively skip spread and named arguments to avoid false positives.
			if ( $arg->unpack || null !== $arg->name ) {
				return [];
			}
		}

		$acceptor = ParametersAcceptorSelector::selectFromArgs( $scope, $args, $classReflection->getConstructor()->getVariants() );
		$parameters = $acceptor->getParameters();

		return \array_merge(
			$this->validateCount( $classReflection, $parameters, $acceptor->isVariadic(), \count( $args ) ),
			$this->validateTypes( $classReflection, $parameters, $acceptor->isVariadic(), $args, $scope )
		);
	}


	private function getCalledClass( StaticCall $node, Scope $scope ): ?ClassReflection {
		if ( $node->class instanceof Node\Name ) {
			return $scope->resolveTypeByName( $node->class )->getClassReflection();
		}

		$reflections = $scope->getType( $node->class )->getObjectClassReflections();
		return 1 === \count( $reflections ) ? $reflections[0] : null;
	}


	private function usesFactoryTrait( ClassReflection $classReflection ): bool {
		foreach ( $classReflection->getTraits( true ) as $trait ) {
			if ( self::FACTORY_TRAIT === $trait->getName() ) {
				return true;
			}
		}

		return false;
	}


	/**
	 * @param array<ParameterReflection> $parameters
	 *
	 * @return list<Rules\IdentifierRuleError>
	 */
	private function validateCount( ClassReflection $classReflection, array $parameters, bool $isVariadic, int $given ): array {
		$required = 0;
		foreach ( $parameters as $parameter ) {
			if ( ! $parameter->isOptional() ) {
				++ $required;
			}
		}
		$maximum = \count( $parameters );

		if ( $given < $required ) {
			return [ $this->countError( $classReflection, $required, $isVariadic ? null : $maximum, $given ) ];
		}
		if ( ! $isVariadic && $given > $maximum ) {
			return [ $this->countError( $classReflection, $required, $maximum, $given ) ];
		}

		return [];
	}


	/**
	 * @param array<ParameterReflection> $parameters
	 * @param array<Node\Arg>            $args
	 *
	 * @return list<Rules\IdentifierRuleError>
	 */
	private function validateTypes( ClassReflection $classReflection, array $parameters, bool $isVariadic, array $args, Scope $scope ): array {
		if ( 0 === \count( $parameters ) ) {
			return [];
		}
		$lastParameter = $parameters[ \array_key_last( $parameters ) ];

		$errors = [];
		foreach ( $args as $index => $arg ) {
			$parameter = $parameters[ $index ] ?? ( $isVariadic ? $lastParameter : null );
			if ( null === $parameter ) {
				continue;
			}

			$parameterType = $parameter->getType();
			$argType = $scope->getType( $arg->value );
			if ( $parameterType->accepts( $argType, $scope->isDeclareStrictTypes() )->yes() ) {
				continue;
			}

			$errors[] = Rules\RuleErrorBuilder::message(
				\sprintf(
					'Parameter #%d $%s of %s::__construct() expects %s, %s given.',
					$index + 1,
					$parameter->getName(),
					$classReflection->getDisplayName(),
					$parameterType->describe( VerbosityLevel::typeOnly() ),
					$argType->describe( VerbosityLevel::typeOnly() )
				)
			)->identifier( $this->identifier )->build();
		}

		return $errors;
	}


	private function countError( ClassReflection $classReflection, int $required, ?int $maximum, int $given ): Rules\IdentifierRuleError {
		if ( null === $maximum ) {
			$expected = \sprintf( 'at least %d', $required );
		} elseif ( $required === $maximum ) {
			$expected = (string) $required;
		} else {
			$expected = \sprintf( '%d-%d', $required, $maximum );
		}

		return Rules\RuleErrorBuilder::message(
			\sprintf(
				'%s::%s() passes %d argument(s) to %s::__construct() which expects %s argument(s).',
				$classReflection->getDisplayName(),
				self::METHOD,
				$given,
				$classReflection->getDisplayName(),
				$expected
			)
		)->identifier( $this->identifier )->build();
	}
}
