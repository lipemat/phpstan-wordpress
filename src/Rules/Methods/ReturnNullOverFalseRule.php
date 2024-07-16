<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeFinder;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node\Stmt\ClassMethod>
 */
class ReturnNullOverFalseRule implements Rule {
	/**
	 * @api
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Returning false in a method without a `bool` return type. Return `null` with `<type>|null` or add `bool` to the return type.';

	/**
	 * @var ?NodeFinder
	 */
	private $nodeFinder;


	public function getNodeType(): string {
		return ClassMethod::class;
	}


	public function processNode( Node $node, Scope $scope ): array {
		if ( null === $node->stmts ) {
			return [];
		}

		if ( $node->returnType instanceof Node ) {
			return [];
		}
		if ( ! $this->nodeFinder instanceof NodeFinder ) {
			$this->nodeFinder = new NodeFinder();
		}

		/** @var Return_[] $returns */
		$returns = $this->nodeFinder->findInstanceOf( $node->stmts, Return_::class );

		$hasFalseType = false;
		$hasTrueType = false;

		foreach ( $returns as $return ) {
			if ( ! $return->expr instanceof Expr ) {
				continue;
			}

			$exprType = $scope->getType( $return->expr );
			if ( ! $exprType->isTrue()->yes() && ! $exprType->isFalse()->yes() ) {
				if ( $exprType->isBoolean()->yes() ) {
					return [];
				}

				continue;
			}

			if ( \method_exists( $exprType, 'getValue' ) && $exprType->getValue() ) {
				$hasTrueType = true;
				continue;
			}

			$hasFalseType = true;
		}

		if ( ! $hasTrueType && $hasFalseType ) {
			$ruleErrorBuilder = RuleErrorBuilder::message( self::ERROR_MESSAGE );
			$ruleErrorBuilder->identifier( 'lipemat.returnNullOverFalse' );
			$ruleErrorBuilder->tip( 'It is preferred to return `null` when the typed value is not available.' );

			return [
				$ruleErrorBuilder->build(),
			];
		}

		return [];
	}
}
