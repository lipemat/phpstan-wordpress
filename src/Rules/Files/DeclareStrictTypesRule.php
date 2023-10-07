<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Files;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Node\FileNode;
use PHPStan\Rules;
use PHPStan\ShouldNotHappenException;

final class DeclareStrictTypesRule implements Rules\Rule {
	public function getNodeType(): string {
		return FileNode::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node instanceof FileNode ) {
			throw new ShouldNotHappenException( \sprintf(
				'Expected node to be instance of "%s", but got instance of "%s" instead.',
				Node\Stmt\Class_::class,
				get_class( $node )
			) );
		}

		$nodes = $node->getNodes();

		if ( 0 === \count( $nodes ) ) {
			return [];
		}

		$firstNode = \array_shift( $nodes );

		if (
			$firstNode instanceof Node\Stmt\InlineHTML
			&& 2 === $firstNode->getEndLine()
			&& 0 === \mb_strpos( $firstNode->value, '#!' )
		) {
			$firstNode = \array_shift( $nodes );
		}

		if ( $firstNode instanceof Node\Stmt\Declare_ ) {
			foreach ( $firstNode->declares as $declare ) {
				if (
					'strict_types' === $declare->key->toLowerString()
					&& $declare->value instanceof Node\Scalar\LNumber
					&& 1 === $declare->value->value
				) {
					return [];
				}
			}
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( 'File is missing a "declare(strict_types=1)" declaration.' );
		$ruleErrorBuilder->identifier( 'declareStrictTypes' );

		return [ $ruleErrorBuilder->build() ];
	}
}
