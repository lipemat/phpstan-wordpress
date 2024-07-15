<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoUnknownMethodCallerRule\Failure;

final class MagicMethodName {
	public function run( $someType, $magic ) {
		$someType->$magic();
	}
}
