<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoIssetOnObjectRule\Success;

use PhpParser\Node\Expr\MethodCall;

final class SkipIssetOnArrayNestedOnObject {
	public function run( MethodCall $methodCall ) {
		if ( isset( $methodCall->args[9] ) ) {
			return $methodCall->args[9];
		}
	}
}
