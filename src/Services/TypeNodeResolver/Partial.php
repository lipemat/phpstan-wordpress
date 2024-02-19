<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;

/**
 * @author Mat Lipe
 * @since  February 2024
 *
 */
class Partial implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension {
	/**
	 * @var TypeNodeResolver
	 */
	private $typeNodeResolver;

	/**
	 * @var bool
	 */
	private $optional = true;


	public function setTypeNodeResolver( TypeNodeResolver $typeNodeResolver ): void {
		$this->typeNodeResolver = $typeNodeResolver;
	}


	public function resolve( TypeNode $typeNode, NameScope $nameScope ): ?Type {
		if ( ! $typeNode instanceof GenericTypeNode ) {
			// returning null means this extension is not interested in this node
			return null;
		}

		$typeName = $typeNode->type;
		if ( '\Partial' !== $typeName->name ) {
			return null;
		}
		$arguments = $typeNode->genericTypes;
		if ( 1 !== \count( $arguments ) && 2 !== \count( $arguments ) ) {
			return null;
		}
		$constantArrays = $this->typeNodeResolver->resolve( $arguments[0], $nameScope )->getConstantArrays();
		$required = [];
		if ( 2 === \count( $arguments ) ) {
			$required = $this->typeNodeResolver->resolve( $arguments[1], $nameScope )->getConstantStrings();
		}
		if ( 0 === \count( $constantArrays ) ) {
			return new ErrorType();
		}

		$constantArray = $constantArrays[0];
		$requiredKeys = \array_map(
			function( ConstantStringType $type ) {
				return $type->getValue();
			},
			$required
		);
		$newTypeBuilder = ConstantArrayTypeBuilder::createEmpty();
		foreach ( $constantArray->getKeyTypes() as $i => $keyType ) {
			$valueType = $constantArray->getValueTypes()[ $i ];
			if ( 0 === \count( $requiredKeys ) || \in_array( $keyType->getValue(), $requiredKeys, true ) ) {
				$newTypeBuilder->setOffsetValueType(
					$keyType,
					$valueType,
					$this->optional
				);
			} else {
				$newTypeBuilder->setOffsetValueType(
					$keyType,
					$valueType,
					$constantArray->isOptionalKey( $i )
				);
			}
		}

		return $newTypeBuilder->getArray();
	}
}
