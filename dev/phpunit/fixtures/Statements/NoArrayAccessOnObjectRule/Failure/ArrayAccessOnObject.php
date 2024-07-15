<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Failure;

use Rector\TypePerfect\Tests\Rules\NoArrayAccessOnObjectRule\Source\SomeClassWithArrayAccess;

final class ArrayAccessOnObject {
	public function run() {
		$someClassWithArrayAccess = new SomeClassWithArrayAccess();
		return $someClassWithArrayAccess['key'];
	}
}
