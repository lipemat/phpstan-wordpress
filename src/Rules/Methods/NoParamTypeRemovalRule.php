<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Php\PhpMethodReflection;
use PHPStan\Rules\Rule;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;

/**
 * Prevent child class from removing parent param type.
 *
 * @implements Rule<ClassMethod>
 */
class NoParamTypeRemovalRule implements Rule {
	/**
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Removing parent param type is forbidden.';


	public function getNodeType(): string {
		return ClassMethod::class;
	}


	/**
	 * @param ClassMethod $node
	 *
	 * @return string[]
	 */
	public function processNode( Node $node, Scope $scope ): array {
		if ( [] === $node->params ) {
			return [];
		}

		$classMethodName = (string) $node->name;
		$parentClassMethodReflection = $this->matchFirstParentClassMethod( $scope, $classMethodName );
		if ( ! $parentClassMethodReflection instanceof PhpMethodReflection ) {
			return [];
		}

		foreach ( $node->params as $paramPosition => $param ) {
			if ( null !== $param->type ) {
				continue;
			}

			$parentParamType = $this->resolveParentParamType( $parentClassMethodReflection, $paramPosition );
			if ( $parentParamType instanceof MixedType ) {
				continue;
			}

			// removed param type!
			return [ self::ERROR_MESSAGE ];
		}

		return [];
	}


	private function resolveParentParamType( PhpMethodReflection $phpMethodReflection, int $paramPosition ): Type {
		foreach ( $phpMethodReflection->getVariants() as $parametersAcceptorWithPhpDoc ) {
			foreach ( $parametersAcceptorWithPhpDoc->getParameters() as $parentParamPosition => $parameterReflectionWithPhpDoc ) {
				if ( $paramPosition !== $parentParamPosition ) {
					continue;
				}

				return $parameterReflectionWithPhpDoc->getNativeType();
			}
		}

		return new MixedType();
	}


	public function hasParentVendorLock( Scope $scope, string $methodName ): bool {
		return $this->matchFirstParentClassMethod( $scope, $methodName ) instanceof MethodReflection;
	}


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
