<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\ReturnNullOverFalseRule\Success;

final class SkipReturnBool {
	public function run(): bool {
		if ( mt_rand( 1, 0 ) ) {
			return true;
		}

		return false;
	}
}
