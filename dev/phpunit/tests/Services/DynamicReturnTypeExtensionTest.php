<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services;

use PHPStan\Testing\TypeInferenceTestCase;

class DynamicReturnTypeExtensionTest extends TypeInferenceTestCase {
	/**
	 * @link https://github.com/szepeviktor/phpstan-wordpress/blob/master/tests/DynamicReturnTypeExtensionTest.php
	 *
	 * @return array<mixed>
	 */
	public static function dataFileAsserts(): iterable {
		// Path to a file with actual asserts of expected types:
		yield from self::gatherAssertTypes( dirname( __DIR__, 2 ) . '/data/get_approved_comments.php' );
		yield from self::gatherAssertTypes( dirname( __DIR__, 2 ) . '/data/get_post_types.php' );
		yield from self::gatherAssertTypes( dirname( __DIR__, 2 ) . '/data/get_term.php' );
		yield from self::gatherAssertTypes( dirname( __DIR__, 2 ) . '/data/get_term_by.php' );
	}


	/**
	 * Go through each `yield` from `dataFileAsserts` and validate the returned types.
	 *
	 * @dataProvider dataFileAsserts
	 *
	 * @param array<string> ...$args
	 */
	public function testFileAsserts( string $assertType, string $file, ...$args ): void {
		$this->assertFileAsserts( $assertType, $file, ...$args );
	}


	public static function getAdditionalConfigFiles(): array {
		return [
			dirname( __DIR__, 2 ) . '/tests.neon',
		];
	}
}
