<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use function PHPStan\Testing\assertType;

/**
 * @author Mat Lipe
 * @since  February 2024
 *
 * @phpstan-import-type DATA from RequiredDataHolder
 */
class RequiredExample {
	/**
	 * @phpstan-param \Required<int> $required
	 *
	 * @return mixed
	 */
	public function invalidType( $required ) {
		return assertType( 'mixed', $required );
	}


	/**
	 * @phpstan-param \Required<array{first?: bool}> $required
	 *
	 * @return mixed
	 */
	public function single( array $required ) {
		return assertType( 'array{first: bool}', $required );
	}


	/**
	 * @phpstan-param \Required<array{first?: bool, second?: string}> $required
	 *
	 * @return mixed
	 */
	public function multiple( array $required ) {
		return assertType( 'array{first: bool, second: string}', $required );
	}


	/**
	 * @phpstan-param \Required<DATA> $required
	 *
	 * @return mixed
	 */
	public function exported( array $required ) {
		return assertType( "array{exclude: string, order_by: string, title: string, display_all: ''|'checked', include_childless_parent: ''|'checked', include_parent: ''|'checked', levels: int|numeric-string, post_type: string}", $required );
	}


	/**
	 * @phpstan-param \Required<array{first?: bool, second?: string}, 'second'> $required
	 *
	 * @return mixed
	 */
	public function withKey( array $required ) {
		return assertType( 'array{first?: bool, second: string}', $required );
	}


	/**
	 * @phpstan-param \Required<DATA, 'include_parent'|'levels'> $required
	 *
	 * @return mixed
	 */
	public function withKeys( array $required ) {
		return assertType( "array{exclude: string, order_by: string, title?: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent: ''|'checked', levels: int|numeric-string, post_type?: string}", $required );
	}
}
