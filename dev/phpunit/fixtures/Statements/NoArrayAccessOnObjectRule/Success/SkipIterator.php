<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Success;

final class SkipIterator {
	public function run() {
		$iterator = new class extends \Iterator {
		};

		return $iterator[0];
	}
}
