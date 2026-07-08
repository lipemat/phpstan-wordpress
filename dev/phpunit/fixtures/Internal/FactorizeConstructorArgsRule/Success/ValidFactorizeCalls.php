<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Internal\FactorizeConstructorArgsRule\Success;

use Lipe\Lib\Container\Factory;

final class ValidFactorizeCalls {
	use Factory;

	public function __construct( int|string|null $id = null ) {
	}


	public static function fromInt( int $id ): static {
		return self::factorize( $id );
	}


	public static function fromNull(): static {
		return self::factorize( null );
	}


	public static function fromNothing(): static {
		return self::factorize();
	}
}
