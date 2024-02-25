<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;

class Sarcastic implements TypeNodeResolverExtension {

	public function resolve( TypeNode $typeNode, NameScope $nameScope ): ?Type {
		if ( ! $typeNode instanceof GenericTypeNode ) {
			// returning null means this extension is not interested in this node
			return null;
		}

		if ( '\Sarcastic' !== $typeNode->type->name ) {
			return null;
		}

		$possibleClasses = [
			'WP_Post',
			'WP_Comment',
			'WP_Term',
			'WP_User',
			'WP_Taxonomy',
		];

		$possibleTypes = [
			new ObjectType( $possibleClasses[ \array_rand( $possibleClasses ) ] ),
			new ArrayType( new StringType(), new IntegerType() ),
			new IntegerType(),
			new StringType(),
			new ArrayType( new IntegerType(), new ObjectType( $possibleClasses[ \array_rand( $possibleClasses ) ] ) ),
		];

		return $possibleTypes[ \array_rand( $possibleTypes ) ];
	}
}
