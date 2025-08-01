<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Rules;

/**
 * Prevent using the `extract()` function.
 *
 * @implements Rules\Rule<Node\Expr\FuncCall>
 */
class NoExtractRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Expr\FuncCall::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node->name instanceof Node\Name ) {
			return [];
		}

		$name = $scope->resolveName( $node->name );
		if ( 'extract' !== \strtolower( $name ) ) {
			return [];
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( 'Function extract() should not be used.' );
		$ruleErrorBuilder->identifier( 'lipemat.noExtract' );
		$ruleErrorBuilder->addTip( 'Using the `extract` function creates variables dynamically which prevents static analysis. Consider using array access or destructuring instead.' );

		return [ $ruleErrorBuilder->build() ];
	}
}
