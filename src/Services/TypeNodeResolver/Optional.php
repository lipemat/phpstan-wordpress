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
 * @author Mat Lipe
 * @since  February 2024
 *
 */
class Optional implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension {
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
		if ( 'Optional' !== $typeName->name && '\Optional' !== $typeName->name ) {
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
