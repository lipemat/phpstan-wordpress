<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use PHPStan\Testing\TypeInferenceTestCase;

/**
 * @author Mat Lipe
 * @since  February 2024
 *
 */
class AtLeastTest extends TypeInferenceTestCase {
	/**
	 * @link https://github.com/szepeviktor/phpstan-wordpress/blob/master/tests/AssertMethodTypeSpecifyingExtensionTest.php
	 *
	 * @return array<mixed>
	 */
	public function dataFileAsserts(): iterable {
		yield from self::gatherAssertTypes( dirname( __DIR__, 3 ) . '/data/TypeNodeResolver/AtLeastExample.php' );
	}


	/**
	 * Go through each `yield` from `dataFileAsserts` and validate the returned types.
	 *
	 * @dataProvider dataFileAsserts
	 *
	 * @param array<string> ...$args
	 */
	public function test_resolve( string $assertType, string $file, ...$args ): void {
		$this->assertFileAsserts( $assertType, $file, ...$args );
	}


	public static function getAdditionalConfigFiles(): array {
		return [
			dirname( __DIR__, 3 ) . '/tests.neon',
		];
	}

}
