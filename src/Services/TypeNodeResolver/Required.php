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
use PHPStan\Type\Type;

/**
 * Add support for a `Required` type node.
 *
 * Makes all keys in an `ConstantArrayType` array shape required.
 *
 * @author  Mat Lipe
 * @since   2.12.0
 *
 * @link    https://phpstan.org/developing-extensions/custom-phpdoc-types
 *
 * @example Required<array{a?: int, b?: string}> becomes array{a: int, b: string}
 * @template T of array<string, mixed>
 */
class Required implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension {
	/**
	 * @var TypeNodeResolver
	 */
	private $typeNodeResolver;

	/**
	 * @var bool
	 */
	private $optional = false;


	public function setTypeNodeResolver( TypeNodeResolver $typeNodeResolver ): void {
		$this->typeNodeResolver = $typeNodeResolver;
	}


	public function resolve( TypeNode $typeNode, NameScope $nameScope ): ?Type {
		if ( ! $typeNode instanceof GenericTypeNode ) {
			// returning null means this extension is not interested in this node
			return null;
		}

		$typeName = $typeNode->type;
		if ( 'Required' !== $typeName->name && '\Required' !== $typeName->name ) {
			return null;
		}
		$arguments = $typeNode->genericTypes;
		if ( 1 !== \count( $arguments ) ) {
			return null;
		}
		$constantArrays = $this->typeNodeResolver->resolve( $arguments[0], $nameScope )->getConstantArrays();
		if ( 0 === \count( $constantArrays ) ) {
			return null;
		}

		$constantArray = $constantArrays[0];
		$newTypeBuilder = ConstantArrayTypeBuilder::createEmpty();
		foreach ( $constantArray->getKeyTypes() as $i => $keyType ) {
			$valueType = $constantArray->getValueTypes()[ $i ];
			$newTypeBuilder->setOffsetValueType(
				$keyType,
				$valueType,
				$this->optional
			);
		}

		return $newTypeBuilder->getArray();
	}
}
