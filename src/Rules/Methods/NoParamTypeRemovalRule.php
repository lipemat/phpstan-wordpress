<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ExtendedParameterReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;

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

	/**
	 * Native types written as a keyword, which may be restored on a parameter.
	 *
	 * @var array<int, string>
	 */
	private const KEYWORD_TYPES = [
		'array',
		'bool',
		'callable',
		'false',
		'float',
		'int',
		'iterable',
		'null',
		'object',
		'string',
		'true',
	];


	public function getNodeType(): string {
		return ClassMethod::class;
	}


	/**
	 * @param ClassMethod $node
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

		foreach ( $node->params as $paramPosition => $param ) {
			if ( null !== $param->type ) {
				continue;
			}

			$parentParamType = $this->resolveParentParamType( $parentClassMethodReflection, $paramPosition );
			if ( $parentParamType instanceof MixedType ) {
				continue;
			}

			$ruleErrorBuilder = RuleErrorBuilder::message( self::ERROR_MESSAGE );
			$ruleErrorBuilder->identifier( 'lipemat.noParamTypeRemoval' );
			$ruleErrorBuilder->line( $param->getStartLine() );

			$typeNode = $this->toTypeNode( $parentParamType );
			if ( $typeNode instanceof Node ) {
				$restoreType = function( Node\Param $methodParam ) use ( $typeNode ): Node\Param {
					$methodParam->type = $typeNode;
					return $methodParam;
				};
				$ruleErrorBuilder->fixNode( $param, $restoreType );
			}

			return [
				$ruleErrorBuilder->build(),
			];
		}

		return [];
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
	 * Class names are fully qualified; PHPStan shortens them when it writes the fix.
	 */
	private function toTypeNode( Type $type ): Node\ComplexType|Node\Identifier|Node\Name|null {
		if ( $type instanceof UnionType ) {
			return $this->toUnionTypeNode( $type );
		}
		return $this->toMemberTypeNode( $type );
	}


	private function toUnionTypeNode( UnionType $type ): ?Node\ComplexType {
		$members = [];
		$nullable = false;
		foreach ( $type->getTypes() as $member ) {
			if ( $member->isNull()->yes() ) {
				$nullable = true;
				continue;
			}
			$memberNode = $this->toMemberTypeNode( $member );
			if ( ! $memberNode instanceof Node ) {
				return null;
			}
			$members[] = $memberNode;
		}

		if ( [] === $members ) {
			return null;
		}
		if ( ! $nullable ) {
			return new Node\UnionType( $members );
		}
		if ( 1 === \count( $members ) && ( $members[0] instanceof Node\Identifier || $members[0] instanceof Node\Name ) ) {
			return new Node\NullableType( $members[0] );
		}

		$members[] = new Node\Identifier( 'null' );
		return new Node\UnionType( $members );
	}


	/**
	 * A keyword, a class, or an intersection of classes.
	 */
	private function toMemberTypeNode( Type $type ): Node\IntersectionType|Node\Identifier|Node\Name|null {
		$classNames = $type->getObjectClassNames();
		if ( 1 === \count( $classNames ) ) {
			return new Node\Name\FullyQualified( $classNames[0] );
		}
		if ( 1 < \count( $classNames ) ) {
			$names = [];
			foreach ( $classNames as $className ) {
				$names[] = new Node\Name\FullyQualified( $className );
			}
			return new Node\IntersectionType( $names );
		}

		$keyword = $type->describe( VerbosityLevel::typeOnly() );
		if ( \in_array( $keyword, self::KEYWORD_TYPES, true ) ) {
			return new Node\Identifier( $keyword );
		}

		return null;
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
