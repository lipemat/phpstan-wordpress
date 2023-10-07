<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Files;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Node\FileNode;
use PHPStan\Rules;

/**
 * Force all files to have a `declare(strict_types=1)` declaration.
 *
 * @implements Rules\Rule<FileNode>
 */
class DeclareStrictTypesRule implements Rules\Rule {
	public function getNodeType(): string {
		return FileNode::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
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
