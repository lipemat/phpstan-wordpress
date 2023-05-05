<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services;

use PHPStan\Testing\TypeInferenceTestCase;

class DynamicReturnTypeExtensionTest extends TypeInferenceTestCase {
	/**
	 * @link https://github.com/szepeviktor/phpstan-wordpress/blob/master/tests/DynamicReturnTypeExtensionTest.php
	 *
	 * @return array
	 */
	public function dataFileAsserts() : iterable {
		// Path to a file with actual asserts of expected types:
		yield from $this->gatherAssertTypes( dirname( __DIR__ ) . '/data/get_post_types.php' );

	}


	/**
	 * Go through each `yield` from `dataFileAsserts` and validate the returned types.
	 *
	 * @dataProvider dataFileAsserts
	 *
	 * @param array<string> ...$args
	 */
	public function testFileAsserts( string $assertType, string $file, ...$args ) : void {
		$this->assertFileAsserts( $assertType, $file, ...$args );
	}


	public static function getAdditionalConfigFiles() : array {
		return [
			dirname( __DIR__, 4 ) . '/vendor/szepeviktor/phpstan-wordpress/extension.neon',
			dirname( __DIR__, 4 ) . '/extension.neon'
		];
	}
}
