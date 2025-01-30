<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Failure;

class SomeClassWithArrayAccess implements \ArrayAccess {
	public function offsetExists( $offset ) {
		return true;
	}

	public function offsetGet( $offset ) {
		return 'value';
	}

	public function offsetSet( $offset, $value ) {
	}

	public function offsetUnset( $offset ) {
	}
}

final class ArrayAccessOnObject {
	public function run() {
		$someClassWithArrayAccess = new SomeClassWithArrayAccess();
		return $someClassWithArrayAccess['key'];
	}
}
