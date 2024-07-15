<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoUnknownPropertyRule\Failure;

final class DynamicName {
	public function run( $unknownType ) {
		$unknownType->{$name};
	}
}
