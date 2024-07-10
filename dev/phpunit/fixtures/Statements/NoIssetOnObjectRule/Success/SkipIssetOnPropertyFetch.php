<?php

declare( strict_types=1 );

namespace Rector\TypePerfect\Tests\Rules\NoIssetOnObjectRule\Fixture;

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
