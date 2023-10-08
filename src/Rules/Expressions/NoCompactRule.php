<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Rules;

/**
 * Prevent using the `compact()` function.
 *
 * @implements Rules\Rule<Node\Expr\FuncCall>
 */
class NoCompactRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Expr\FuncCall::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node->name instanceof Node\Name ) {
			return [];
		}

		if ( 'compact' !== $scope->resolveName( $node->name ) ) {
			return [];
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( 'Function compact() should not be used.' );
		$ruleErrorBuilder->identifier( 'lipemat.noCompact' );
		$ruleErrorBuilder->addTip( 'Using the `compact` function prevents static analysis. Consider declaring an associative array instead.' );

		return [ $ruleErrorBuilder->build() ];
	}
}
