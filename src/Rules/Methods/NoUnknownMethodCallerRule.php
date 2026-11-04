<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use Lipe\Lib\Phpstan\Traits\UnknownSubjectError;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\DependencyInjection\RegisteredRule;
use PHPStan\Rules\Rule;
use PHPStan\Type\ErrorType;
use PHPStan\Type\MixedType;

/**
 * Prevent calling a method on an unknown object.
 *
 * Level 6 is where PHPStan starts requiring the missing types.
 *
 * @implements Rule<MethodCall>
 */
#[RegisteredRule( level: 6 )]
class NoUnknownMethodCallerRule implements Rule {
	use UnknownSubjectError;

	/**
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Calling `%s` method on unknown `%s` can skip important errors. Make sure the type is known.';


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

		return [
			$this->unknownSubjectError( $node, self::ERROR_MESSAGE, 'lipemat.noUnknownMethodCaller' ),
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
