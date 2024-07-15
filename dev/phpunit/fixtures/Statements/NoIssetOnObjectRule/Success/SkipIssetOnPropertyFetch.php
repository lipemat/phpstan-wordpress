<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoIssetOnObjectRule\Success;

class Foo {

}

class SkipIssetOnPropertyFetch {
	private $foo;


	public function sayHello(): void {
		$this->initializeFoo();

		$this->foo->sayHello();
	}


	private function initializeFoo(): void {
		if ( ! isset( $this->foo ) ) {
			$this->foo = new Foo();
		}
	}
}
