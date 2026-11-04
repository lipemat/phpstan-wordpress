<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\DependencyInjection\RegisteredRule;
use PHPStan\Rules;

/**
 * Prevent using the `compact()` function.
 *
 * @implements Rules\Rule<Node\Expr\FuncCall>
 */
#[RegisteredRule( level: 0 )]
class NoCompactRule implements Rules\Rule {
	/**
	 * @var string
	 */
	private const VARIABLE_NAME = '/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/';


	public function getNodeType(): string {
		return Node\Expr\FuncCall::class;
	}


	/**
	 * @param Node\Expr\FuncCall $node
	 */
	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node->name instanceof Node\Name ) {
			return [];
		}

		if ( 'compact' !== \strtolower( $scope->resolveName( $node->name ) ) ) {
			return [];
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( 'Function compact() should not be used.' );
		$ruleErrorBuilder->identifier( 'lipemat.noCompact' );
		$ruleErrorBuilder->addTip( 'Using the `compact` function prevents static analysis. Consider declaring an associative array instead.' );

		$array = $this->toArray( $node, $scope );
		if ( $array instanceof Node\Expr\Array_ ) {
			$ruleErrorBuilder->fixNode( $node, fn(): Node\Expr\Array_ => $array );
		}

		return [ $ruleErrorBuilder->build() ];
	}


	/**
	 * `compact()` also takes arrays of names and silently skips undefined
	 * variables, so anything but a list of known variable names is left alone.
	 */
	private function toArray( Node\Expr\FuncCall $node, Analyser\Scope $scope ): ?Node\Expr\Array_ {
		if ( [] === $node->args ) {
			return null;
		}

		$items = [];
		foreach ( $node->args as $arg ) {
			if ( ! $arg instanceof Node\Arg ) {
				return null;
			}
			if ( $arg->unpack || $arg->name instanceof Node\Identifier ) {
				return null;
			}
			if ( ! $arg->value instanceof Node\Scalar\String_ ) {
				return null;
			}

			$name = $arg->value->value;
			if ( 1 !== \preg_match( self::VARIABLE_NAME, $name ) ) {
				return null;
			}
			if ( ! $scope->hasVariableType( $name )->yes() ) {
				return null;
			}

			$items[] = new Node\ArrayItem( new Node\Expr\Variable( $name ), new Node\Scalar\String_( $name ) );
		}

		return new Node\Expr\Array_( $items );
	}
}
