<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Failure;


class ParentClass implements \ArrayAccess {
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

class ChildOfSomeClassWithArrayAccess extends ParentClass {
}



final class ArrayAccessOnNestedObject {
	public function run() {
		$someClassWithArrayAccess = new ChildOfSomeClassWithArrayAccess();
		return $someClassWithArrayAccess['key'];
	}
}
