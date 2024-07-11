<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\ErrorType;
use PHPStan\Type\MixedType;

/**
 * @implements Rule<MethodCall>
 */
class NoMixedMethodCallerRule implements Rule {
	/**
	 * @var ?Standard
	 */
	private $printerStandard;

	/**
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Mixed variable in a `%s->...()` can skip important errors. Make sure the type is known.';


	public function getNodeType(): string {
		return MethodCall::class;
	}


	public function processNode( Node $node, Scope $scope ): array {
		$callerType = $scope->getType( $node->var );

		if ( ! $callerType instanceof MixedType ) {
			return [];
		}

		if ( $callerType instanceof ErrorType ) {
			return [];
		}

		// if error, skip as well for false positive
		if ( $this->isPreviousTypeErrorType( $node, $scope ) ) {
			return [];
		}

		if ( ! $this->printerStandard instanceof Standard ) {
			$this->printerStandard = new Standard();
		}

		$printedMethodCall = $this->printerStandard->prettyPrintExpr( $node->var );

		return [
			sprintf( self::ERROR_MESSAGE, $printedMethodCall ),
		];
	}


	private function isPreviousTypeErrorType( MethodCall $methodCall, Scope $scope ): bool {
		$currentMethodCall = $methodCall;
		while ( $currentMethodCall->var instanceof MethodCall ) {
			$previousType = $scope->getType( $currentMethodCall->var );
			if ( $previousType instanceof ErrorType ) {
				return true;
			}

			$currentMethodCall = $currentMethodCall->var;
		}

		return false;
	}
}
