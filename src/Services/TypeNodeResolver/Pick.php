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
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

class Pick implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension {
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

		if ( 'Pick' !== $typeNode->type->name && '\Pick' !== $typeNode->type->name ) {
			return null;
		}

		$arguments = $typeNode->genericTypes;
		if ( 2 !== count( $arguments ) ) {
			return new ErrorType();
		}

		$arrayType = $this->typeNodeResolver->resolve( $arguments[0], $nameScope );
		$keysType = $this->typeNodeResolver->resolve( $arguments[1], $nameScope );

		$constantArrays = $arrayType->getConstantArrays();
		if ( 0 === count( $constantArrays ) ) {
			return new ErrorType();
		}

		$newTypes = [];
		foreach ( $constantArrays as $constantArray ) {
			$newTypeBuilder = ConstantArrayTypeBuilder::createEmpty();
			foreach ( $constantArray->getKeyTypes() as $i => $keyType ) {
				if ( ! $keysType->isSuperTypeOf( $keyType )->yes() ) {
					// eliminate keys that aren't in the Pick type
					continue;
				}

				$valueType = $constantArray->getValueTypes()[ $i ];
				$newTypeBuilder->setOffsetValueType(
					$keyType,
					$valueType,
					$constantArray->isOptionalKey( $i )
				);
			}

			$newTypes[] = $newTypeBuilder->getArray();
		}

		return TypeCombinator::union( ...$newTypes );
	}
}
