<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use function PHPStan\Testing\assertType;

/**
 * @notice The actual array shapes are created in the
 *         /dev/stubs/pick-example.php file.
 *
 *         They must be in a stub and preloaded, or the alias
 *         will not be resolved during the test.
 *
 *         Local phpstan types are also required for resolution.
 *
 * @phpstan-import-type DATA from PickDataHolder
 */
class PickExample {
	/**
	 * @phpstan-param Pick<array{first?: bool}> $pick
	 *
	 * @return mixed
	 */
	public function invalidType( $pick ) {
		return assertType( 'mixed', $pick );
	}


	/**
	 * @phpstan-param Pick<int, 'first'> $pick
	 *
	 * @return mixed
	 */
	public function invalidType2( $pick ) {
		return assertType( 'mixed', $pick );
	}


	/**
	 * @phpstan-param Pick<array{first?: bool, second: bool}, 'first'> $pick
	 *
	 * @return mixed
	 */
	public function single( array $pick ) {
		return assertType( 'array{first?: bool}', $pick );
	}


	/**
	 * @phpstan-param \Pick<array{first?: bool, third: bool, second: string}, 'first'|'second'> $pick
	 *
	 * @return mixed
	 */
	public function multiple( array $pick ) {
		return assertType( 'array{first?: bool, second: string}', $pick );
	}


	/**
	 * @phpstan-param Pick<DATA, 'title'|'post_type'> $pick
	 *
	 * @return mixed
	 */
	public function exported( array $pick ) {
		return assertType( 'array{title?: string, post_type?: string}', $pick );
	}


	/**
	 * @phpstan-param \AtLeast<\Union<Pick<DATA, 'title'>,Pick<DATA,'post_type'|'levels'>>, 'title'> $pick
	 *
	 * @return mixed
	 */
	public function combined( array $pick ) {
		return assertType( 'array{title: string, levels?: int|numeric-string, post_type?: string}', $pick );
	}

}
