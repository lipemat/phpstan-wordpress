<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Isset_;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\TypeCombinator;
use Rector\TypePerfect\Guard\EmptyIssetGuard;

/**
 * Prevent using isset() on an object in favor of instanceof.
 *
 * @implements Rule<Isset_>
 */
class NoIssetOnObjectRule implements Rule {
	/**
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Use `instanceof` instead of `isset()` on an object.';


	public function getNodeType(): string {
		return Isset_::class;
	}


	/**
	 * @param Isset_ $node
	 */
	public function processNode( Node $node, Scope $scope ): array {
		foreach ( $node->vars as $var ) {
			if ( $this->isLegal( $var, $scope ) ) {
				continue;
			}

			$ruleErrorBuilder = RuleErrorBuilder::message( self::ERROR_MESSAGE );
			$ruleErrorBuilder->identifier( 'lipemat.noIssetOnObject' );

			return [
				$ruleErrorBuilder->build(),
			];
		}

		return [];
	}


	public function isLegal( Expr $expr, Scope $scope ): bool {
		if ( $expr instanceof ArrayDimFetch ) {
			return true;
		}

		if ( ! $expr instanceof Variable ) {
			return true;
		}

		if ( $expr->name instanceof Expr ) {
			return true;
		}

		if ( ! $scope->hasVariableType( $expr->name )->yes() ) {
			return true;
		}

		$varType = $scope->getType( $expr );
		$varType = TypeCombinator::removeNull( $varType );
		return $varType->getObjectClassNames() === [];
	}
}
