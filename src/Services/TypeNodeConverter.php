<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services;

use PhpParser\Node;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;

/**
 * Convert a native PHPStan type into a PhpParser type declaration node.
 *
 * Class names are fully qualified; PHPStan shortens them when it writes a fix.
 */
class TypeNodeConverter {
	/**
	 * Native types written as a keyword, which may be used in a type declaration.
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


	/**
	 * Null when the type cannot be written as a declaration.
	 */
	public function toTypeNode( Type $type ): Node\ComplexType|Node\Identifier|Node\Name|null {
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
}
