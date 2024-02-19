<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use function PHPStan\Testing\assertType;

/**
 * @author Mat Lipe
 * @since  February 2024
 *
 * @phpstan-import-type DATA from PartialDataHolder
 */
class PartialExample {
	/**
	 * @phpstan-param \Partial<int> $Partial
	 *
	 * @return mixed
	 */
	public function invalidType( $Partial ) {
		return assertType( 'mixed', $Partial );
	}


	/**
	 * @phpstan-param \Partial<array{first: bool}> $Partial
	 *
	 * @return mixed
	 */
	public function single( array $Partial ) {
		return assertType( 'array{first?: bool}', $Partial );
	}


	/**
	 * @phpstan-param \Partial<array{first: bool, second: string}> $Partial
	 *
	 * @return mixed
	 */
	public function multiple( array $Partial ) {
		return assertType( 'array{first?: bool, second?: string}', $Partial );
	}


	/**
	 * @phpstan-param \Partial<array{first: bool, second: string}, 'second'> $Partial
	 *
	 * @return mixed
	 */
	public function specified( array $Partial ) {
		return assertType( 'array{first: bool, second?: string}', $Partial );
	}


	/**
	 * @phpstan-param \Partial<DATA> $Partial
	 *
	 * @return mixed
	 */
	public function exported( array $Partial ) {
		return assertType( "array{exclude?: string, order_by?: string, title?: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels?: int|numeric-string, post_type?: string}", $Partial );
	}


	/**
	 * @phpstan-param \Partial<DATA, 'exclude'> $Partial
	 *
	 * @return mixed
	 */
	public function exportedSpecified( array $Partial ) {
		return assertType( "array{exclude?: string, order_by: string, title?: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels?: int|numeric-string, post_type?: string}", $Partial );
	}


	/**
	 * @phpstan-param \Required<\Partial<\Required<DATA>, 'exclude'|'title'|'order_by'>, 'title'> $Partial
	 *
	 * @return mixed
	 */
	public function combined( array $Partial ) {
		return assertType( "array{exclude?: string, order_by?: string, title: string, display_all: ''|'checked', include_childless_parent: ''|'checked', include_parent: ''|'checked', levels: int|numeric-string, post_type: string}", $Partial );
	}
}
