<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Reflection;
use PHPStan\Rules;
use PHPStan\ShouldNotHappenException;

final class NoConstructorParameterWithDefaultValueRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Stmt\ClassMethod::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node instanceof Node\Stmt\ClassMethod ) {
			throw new ShouldNotHappenException( \sprintf(
				'Expected node to be instance of "%s", but got instance of "%s" instead.',
				Node\Stmt\Class_::class,
				get_class( $node )
			) );
		}

		if ( '__construct' !== $node->name->toLowerString() ) {
			return [];
		}

		if ( 0 === \count( $node->params ) ) {
			return [];
		}

		$params = \array_filter( $node->params, static function( Node\Param $node ): bool {
			return null !== $node->default;
		} );

		if ( 0 === \count( $params ) ) {
			return [];
		}

		/** @var Reflection\ClassReflection $classReflection */
		$classReflection = $scope->getClassReflection();

		if ( $classReflection->isAnonymous() ) {
			return \array_map( static function( Node\Param $node ): Rules\RuleError {
				/** @var Node\Expr\Variable $variable */
				$variable = $node->var;

				/** @var string $parameterName */
				$parameterName = $variable->name;

				$ruleErrorBuilder = Rules\RuleErrorBuilder::message( \sprintf(
					'Constructor in anonymous class has parameter $%s with default value.',
					$parameterName
                ) );
				$ruleErrorBuilder->identifier( 'noAnonConstructorParameterDefaultValue' );

				return $ruleErrorBuilder->build();
			}, $params );
		}

		$className = $classReflection->getName();

		return \array_map( function( Node\Param $node ) use ( $className ) {
			/** @var Node\Expr\Variable $variable */
			$variable = $node->var;

			/** @var string $parameterName */
			$parameterName = $variable->name;

			$ruleErrorBuilder = Rules\RuleErrorBuilder::message( \sprintf(
				'Constructor in %s has parameter $%s with default value.',
				$className,
				$parameterName
			) );
			$ruleErrorBuilder->identifier( 'noConstructorParameterDefaultValue' );

			return $ruleErrorBuilder->build();
		}, $params );
	}
}
