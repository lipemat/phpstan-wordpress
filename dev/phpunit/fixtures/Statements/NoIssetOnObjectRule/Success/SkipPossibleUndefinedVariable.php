<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoIssetOnObjectRule\Success;

final class SkipPossibleUndefinedVariable {
	public function run( bool $condition ) {
		if ( $condition ) {
			$object = new \stdClass();
		}

		if ( isset( $object ) ) {
			$object->foo = 'bar';
		}
	}
}
