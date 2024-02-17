<?php
declare( strict_types=1 );

use PHPStan\Testing\TypeInferenceTestCase;

/**
 * @author Mat Lipe
 * @since  February 2024
 *
 */
class StubsTest extends TypeInferenceTestCase {
	/**
	 * @link https://github.com/szepeviktor/phpstan-wordpress/blob/master/tests/DynamicReturnTypeExtensionTest.php
	 *
	 * @return array<mixed>
	 */
	public function dataFileAsserts(): iterable {
		// Path to a file with actual asserts of expected types:
		yield from $this->gatherAssertTypes( dirname( __DIR__ ) . '/data/WP_Widget.php' );
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
			dirname( __DIR__ ) . '/tests.neon',
		];
	}
}
