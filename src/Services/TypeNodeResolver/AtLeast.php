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
 * Add support for a `AtLeast` type node.
 *
 * Makes specified keys in an `ConstantArrayType` array shape required while
 * leaving the rest of the keys as is.
 *
 * @author  Mat Lipe
 * @since   2.12.0
 *
 * @link    https://phpstan.org/developing-extensions/custom-phpdoc-types
 *
 * @example AtLeast<array{a?: int, b?: string}, 'a'> becomes array{a: int, b?: string}
 *
 * @template T of array<string, mixed>
 * @template U of string
 */
class AtLeast implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension {
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
		if ( 'AtLeast' !== $typeName->name && '\AtLeast' !== $typeName->name ) {
			return null;
		}
		$arguments = $typeNode->genericTypes;
		if ( 2 !== \count( $arguments ) ) {
			return new ErrorType();
		}
		$constantArrays = $this->typeNodeResolver->resolve( $arguments[0], $nameScope )->getConstantArrays();
		$required = $this->typeNodeResolver->resolve( $arguments[1], $nameScope )->getConstantStrings();
		if ( 0 === \count( $constantArrays ) || 0 === \count( $required ) ) {
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
			$newTypeBuilder->setOffsetValueType(
				$keyType,
				$valueType,
				! \in_array( $keyType->getValue(), $requiredKeys, true )
			);
		}

		return $newTypeBuilder->getArray();
	}
}
