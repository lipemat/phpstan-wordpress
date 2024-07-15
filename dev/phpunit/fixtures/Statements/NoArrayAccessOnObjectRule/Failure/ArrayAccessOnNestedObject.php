<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Failure;

use Rector\TypePerfect\Tests\Rules\NoArrayAccessOnObjectRule\Source\ChildOfSomeClassWithArrayAccess;

final class ArrayAccessOnNestedObject {
	public function run() {
		$someClassWithArrayAcces = new ChildOfSomeClassWithArrayAccess();
		return $someClassWithArrayAcces['key'];
	}
}
