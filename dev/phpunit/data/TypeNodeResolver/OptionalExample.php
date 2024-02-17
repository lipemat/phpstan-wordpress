<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use function PHPStan\Testing\assertType;

/**
 * @author Mat Lipe
 * @since  February 2024
 *
 * @phpstan-import-type DATA from OptionalDataHolder
 */
class OptionalExample {
	/**
	 * @phpstan-param Optional<int> $Optional
	 *
	 * @return mixed
	 */
	public function invalidType( $Optional ) {
		return assertType( 'Lipe\Lib\Phpstan\Services\TypeNodeResolver\Optional<int>', $Optional );
	}


	/**
	 * @phpstan-param \Optional<array{first: bool}> $Optional
	 *
	 * @return mixed
	 */
	public function single( array $Optional ) {
		return assertType( 'array{first?: bool}', $Optional );
	}


	/**
	 * @phpstan-param Optional<array{first: bool, second: string}> $Optional
	 *
	 * @return mixed
	 */
	public function multiple( array $Optional ) {
		return assertType( 'array{first?: bool, second?: string}', $Optional );
	}


	/**
	 * @phpstan-param Optional<DATA> $Optional
	 *
	 * @return mixed
	 */
	public function exported( array $Optional ) {
		return assertType( "array{exclude?: string, order_by?: string, title?: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels?: int|numeric-string, post_type?: string}", $Optional );
	}
}
