<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Rules;
use PHPStan\ShouldNotHappenException;

final class NoCompactRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Expr\FuncCall::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node instanceof Node\Expr\FuncCall ) {
			throw new ShouldNotHappenException( \sprintf(
				'Expected node to be instance of "%s", but got instance of "%s" instead.',
				Node\Stmt\Class_::class,
				get_class( $node )
			) );
		}

		if ( ! $node->name instanceof Node\Name ) {
			return [];
		}

		if ( 'compact' !== $scope->resolveName( $node->name ) ) {
			return [];
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( 'Function compact() should not be used.' );
		$ruleErrorBuilder->identifier( 'noCompact' );

		return [ $ruleErrorBuilder->build() ];
	}
}
