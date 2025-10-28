<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;

/**
 * Add support for a `Union` type node.
 *
 * Combines 2 or more `ConstantArrayType` array shapes into a single `ConstantArrayType` array shape.
 *
 * @author  Mat Lipe
 * @since   2.12.0
 *
 * @link    https://phpstan.org/developing-extensions/custom-phpdoc-types
 *
 * @example Union<array{a: int}, array{b: string}> becomes array{a: int, b: string}
 *
 * @template T of array<string, mixed>
 * @template U of array<string, mixed>
 * @template W of array<string, mixed>
 */
class Union implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension {
	/**
	 * @var TypeNodeResolver
	 */
	private $typeNodeResolver;


	public function setTypeNodeResolver( TypeNodeResolver $typeNodeResolver ): void {
		$this->typeNodeResolver = $typeNodeResolver;
	}


	public function resolve( TypeNode $typeNode, NameScope $nameScope ): ?Type {
		if ( ! $typeNode instanceof GenericTypeNode ) {
			// returning null means this extension is not interested in this node
			return null;
		}

		$typeName = $typeNode->type;
		if ( '\Union' !== $typeName->name ) {
			return null;
		}
		$arguments = $typeNode->genericTypes;
		/** @var ConstantArrayType[] $passedTypes */
		$passedTypes = \array_filter(
			\array_map(
				function( TypeNode $typeNode ) use ( $nameScope ): ?ConstantArrayType {
					$type = $this->typeNodeResolver->resolve( $typeNode, $nameScope );
					$arrays = $type->getConstantArrays();
					if ( 1 !== \count( $arrays ) ) {
						return null;
					}
					return $arrays[0];
				},
				$arguments
			)
		);

		if ( 0 === \count( $passedTypes ) ) {
			return new ErrorType();
		}

		$newTypeBuilder = ConstantArrayTypeBuilder::createEmpty();
		foreach ( $passedTypes as $constantArray ) {
			foreach ( $constantArray->getKeyTypes() as $i => $keyType ) {
				$valueType = $constantArray->getValueTypes()[ $i ];
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
