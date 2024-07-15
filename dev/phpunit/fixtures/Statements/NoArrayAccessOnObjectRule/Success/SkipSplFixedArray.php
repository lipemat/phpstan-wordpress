<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Success;

use SplFixedArray;

final class SkipSplFixedArray {
	public function run( SplFixedArray $splFixedArray ) {
		return $splFixedArray[0];
	}
}
