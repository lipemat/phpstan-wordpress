<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use Lipe\Lib\Phpstan\Services\TypeNodeConverter;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\DependencyInjection\RegisteredRule;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ExtendedParameterReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MissingMethodFromReflectionException;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;

/**
 * Prevent child class from removing parent param type.
 *
 * @implements Rule<ClassMethod>
 */
#[RegisteredRule( level: 0 )]
class NoParamTypeRemovalRule implements Rule {
	/**
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Removing parent param type is forbidden.';

	private TypeNodeConverter $typeNodeConverter;


	public function __construct() {
		$this->typeNodeConverter = new TypeNodeConverter();
	}


	public function getNodeType(): string {
		return ClassMethod::class;
	}


	/**
	 * @param ClassMethod $node
	 *
	 * @throws ShouldNotHappenException
	 * @throws MissingMethodFromReflectionException
	 */
	public function processNode( Node $node, Scope $scope ): array {
		if ( [] === $node->params ) {
			return [];
		}

		$classMethodName = (string) $node->name;
		$parentClassMethodReflection = $this->matchFirstParentClassMethod( $scope, $classMethodName );
		if ( null === $parentClassMethodReflection ) {
			return [];
		}

		$removedParams = [];
		$typeNodes = [];
		foreach ( $node->params as $paramPosition => $param ) {
			if ( null !== $param->type ) {
				continue;
			}

			$parentParamType = $this->resolveParentParamType( $parentClassMethodReflection, $paramPosition );
			if ( $parentParamType instanceof MixedType ) {
				continue;
			}

			$removedParams[ $paramPosition ] = $param;
			$typeNode = $this->typeNodeConverter->toTypeNode( $parentParamType );
			if ( $typeNode instanceof Node ) {
				$typeNodes[ $paramPosition ] = $typeNode;
			}
		}

		$errors = [];
		foreach ( $removedParams as $paramPosition => $param ) {
			$ruleErrorBuilder = RuleErrorBuilder::message( self::ERROR_MESSAGE );
			$ruleErrorBuilder->identifier( 'lipemat.noParamTypeRemoval' );
			$ruleErrorBuilder->line( $param->getStartLine() );

			if ( isset( $typeNodes[ $paramPosition ] ) ) {
				// Identical fixes on every error, so params sharing a line are fixed in one round.
				foreach ( $typeNodes as $fixPosition => $typeNode ) {
					$ruleErrorBuilder->fixNode(
						$removedParams[ $fixPosition ],
						function( Node\Param $methodParam ) use ( $typeNode ): Node\Param {
							$methodParam->type = $typeNode;
							return $methodParam;
						}
					);
				}
			}

			$errors[] = $ruleErrorBuilder->build();
		}

		return $errors;
	}


	private function resolveParentParamType( MethodReflection $phpMethodReflection, int $paramPosition ): Type {
		foreach ( $phpMethodReflection->getVariants() as $parametersAcceptorWithPhpDoc ) {
			foreach ( $parametersAcceptorWithPhpDoc->getParameters() as $parentParamPosition => $parameterReflectionWithPhpDoc ) {
				if ( $paramPosition !== $parentParamPosition ) {
					continue;
				}

				if ( $parameterReflectionWithPhpDoc instanceof ExtendedParameterReflection ) {
					return $parameterReflectionWithPhpDoc->getNativeType();
				}
			}
		}

		return new MixedType();
	}


	/**
	 * @throws MissingMethodFromReflectionException
	 */
	public function hasParentVendorLock( Scope $scope, string $methodName ): bool {
		return $this->matchFirstParentClassMethod( $scope, $methodName ) instanceof MethodReflection;
	}


	/**
	 * @throws MissingMethodFromReflectionException
	 */
	public function matchFirstParentClassMethod( Scope $scope, string $methodName ): ?MethodReflection {
		$classReflection = $scope->getClassReflection();
		if ( ! $classReflection instanceof ClassReflection ) {
			return null;
		}

		// the classes have higher priority, e.g., priority in class covariance
		foreach ( $classReflection->getParents() as $parentClassReflection ) {
			if ( $parentClassReflection->hasNativeMethod( $methodName ) ) {
				return $parentClassReflection->getNativeMethod( $methodName );
			}
		}

		foreach ( $classReflection->getAncestors() as $ancestorClassReflection ) {
			if ( $classReflection === $ancestorClassReflection ) {
				continue;
			}

			if ( ! $ancestorClassReflection->hasNativeMethod( $methodName ) ) {
				continue;
			}

			return $ancestorClassReflection->getNativeMethod( $methodName );
		}

		return null;
	}
}
