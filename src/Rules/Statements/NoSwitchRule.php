<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Rules;

/**
 * Prevent using the `switch()` statement.
 *
 * @implements Rules\Rule<Node\Stmt\Switch_>
 */
class NoSwitchRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Stmt\Switch_::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( 'Control structures using `switch` should not be used.' );
		$ruleErrorBuilder->identifier( 'lipemat.noSwitch' );
		if ( PHP_VERSION_ID >= 80000 ) {
			$ruleErrorBuilder->addTip( 'The `switch` statement uses loose comparison. Consider using a `match` statement instead.' );
		} else {
			$ruleErrorBuilder->addTip( 'The `switch` statement uses loose comparison.' );
		}

		return [
			$ruleErrorBuilder->build(),
		];
	}
}
