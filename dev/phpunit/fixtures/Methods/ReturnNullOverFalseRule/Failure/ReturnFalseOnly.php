<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\ReturnNullOverFalseRule\Failure;

final class ReturnFalseOnly {
	public function run() {
		if ( mt_rand( 1, 0 ) ) {
			return 1000;
		}

		return false;
	}
}
