<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Success;

final class SkipOnArray {
	public function run( array $values ) {
		return $values['key'];
	}
}
