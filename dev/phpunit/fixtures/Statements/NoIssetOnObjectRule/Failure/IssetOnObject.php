<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoIssetOnObjectRule\Failure;

use stdClass;

final class IssetOnObject {
	public function run() {
		$object = null;

		if ( mt_rand( 0, 100 ) ) {
			$object = new stdClass();
		}

		if ( isset( $object ) ) {
			return $object;
		}
	}
}
