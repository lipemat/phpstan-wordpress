<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoIssetOnObjectRule\Success;

final class SkipIssetOnArray {
	public function run( array $values ) {
		if ( isset( $values[9] ) ) {
			return $values[9];
		}
	}
}
