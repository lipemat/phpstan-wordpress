<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Rules;
use PHPStan\ShouldNotHappenException;

final class NoEvalRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Expr\Eval_::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node instanceof Node\Expr\Eval_ ) {
			throw new ShouldNotHappenException( \sprintf(
				'Expected node to be instance of "%s", but got instance of "%s" instead.',
				Node\Stmt\Class_::class,
				get_class( $node )
			) );
		}
		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( 'Language construct eval() should not be used.' );

		return [ $ruleErrorBuilder->build() ];
	}
}
