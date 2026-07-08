<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Internal\FactorizeConstructorArgsRule\Failure;

use Lipe\Lib\Container\Factory;

final class WrongArgumentType {
	use Factory;

	public function __construct( int $id ) {
	}


	public static function make(): static {
		return self::factorize( 'not-an-int' );
	}
}
