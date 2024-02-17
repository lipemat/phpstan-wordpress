<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use function PHPStan\Testing\assertType;

/**
 * @notice The actual array shapes are created in the
 *        /dev/stubs/at-least-example.php file.
 *
 *        They must be in a stub and preloaded, or the alias
 *        will not be resolved during the test.
 *
 *        Local phpstan types are also required for resolution.
 *
 * @phpstan-import-type AT_LEAST_DATA from AtLeastDataHolder
 */
class AtLeastExample {

	/**
	 * @phpstan-param AtLeast<int, string> $atLeast
	 *
	 * @return mixed
	 */
	public function invalidType( $atLeast ) {
		return assertType( 'mixed', $atLeast );
	}


	/**
	 * @phpstan-param \AtLeast<array{first?: bool}, 'first'> $atLeast
	 *
	 * @return mixed
	 */
	public function single( array $atLeast ) {
		return assertType( 'array{first: bool}', $atLeast );
	}


	/**
	 * @phpstan-param AtLeast<array{first?: bool, second?: string}, 'first'|'second'> $atLeast
	 *
	 * @return mixed
	 */
	public function multiple( array $atLeast ) {
		return assertType( 'array{first: bool, second: string}', $atLeast );
	}


	/**
	 * @phpstan-param AtLeast<array{first?: bool, second?: string}, 'first'> $atLeast
	 *
	 * @return mixed
	 */
	public function some( array $atLeast ) {
		return assertType( 'array{first: bool, second?: string}', $atLeast );
	}


	/**
	 * @phpstan-param AtLeast<AT_LEAST_DATA, 'title'|'post_type'> $atLeast
	 *
	 * @return mixed
	 */
	public function exported( array $atLeast ) {
		return assertType( "array{exclude: string, order_by: string, title: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels?: int|numeric-string, post_type: string}", $atLeast );
	}

}
