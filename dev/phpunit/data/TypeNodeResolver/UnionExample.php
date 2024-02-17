<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver;

use function PHPStan\Testing\assertType;

/**
 * @notice The actual array shapes are created in the
 *         /dev/stubs/union-example.php file.
 *
 *         They must be in a stub and preloaded, or the alias
 *         will not be resolved during the test.
 *
 *         Local phpstan types are also required for resolution.
 *
 *
 * @phpstan-import-type EXPORTED from DataHolder
 *
 * @phpstan-type IMPORTED array{}
 *
 * @phpstan-type LOCAL array{}
 */
class UnionExample {
	/**
	 * @phpstan-param Union<int, string> $union
	 *
	 * @return mixed
	 */
	public function invalidTypes( $union ) {
		return assertType( 'mixed', $union );
	}


	/**
	 * @phpstan-param \Union<array{first: bool}> $single
	 *
	 * @return mixed|null
	 */
	public function single( array $single ) {
		return assertType( 'array{first: bool}', $single );
	}


	/**
	 * @phpstan-param Union<array{first: bool}, array{second: bool}> $union
	 *
	 * @return mixed
	 */
	public function localUnion( array $union ) {
		return assertType( 'array{first: bool, second: bool}', $union );
	}


	/**
	 * @phpstan-param Union<array{first: bool, changed: numeric-string}, array{second: bool, changed: true}> $union
	 *
	 * @return mixed
	 */
	public function localOverride( array $union ) {
		return assertType( 'array{first: bool, changed: true, second: bool}', $union );
	}


	/**
	 * @phpstan-param LOCAL $local
	 *
	 * @return mixed
	 */
	public function local( $local ) {
		return assertType( "array{display-posts?: string, exclude: string, include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels: int|numeric-string, new_widget: 'list'|'widget', single: ''|'checked', taxonomy?: string, title?: string, order_by: int|string}", $local );
	}


	/**
	 * @phpstan-param EXPORTED $imported
	 *
	 * @return mixed
	 */
	public function exported( array $imported ) {
		return assertType( "array{exclude: string, order_by: string, title?: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels?: int|numeric-string, post_type?: string}", $imported );
	}


	/**
	 * @phpstan-param IMPORTED $imported
	 *
	 * @return mixed
	 */
	public function imported( array $imported ) {
		return assertType( "array{exclude: string, order_by: string, title?: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels?: int|numeric-string, post_type?: string, display_everywhere?: string, parent_page?: int|numeric-string}", $imported );
	}


	/**
	 * @phpstan-param Union<IMPORTED, LOCAL> $union
	 *
	 * @return mixed
	 */
	public function localUnionTypes( array $union ) {
		return assertType( "array{exclude: string, order_by: int|string, title?: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels: int|numeric-string, post_type?: string, display_everywhere?: string, parent_page?: int|numeric-string, display-posts?: string, new_widget: 'list'|'widget', single: ''|'checked', taxonomy?: string}", $union );
	}


	/**
	 * @phpstan-param \Union<IMPORTED, LOCAL, array{localized: true}> $union
	 *
	 * @return mixed
	 */
	public function combineAll( array $union ) {
		return assertType( "array{exclude: string, order_by: int|string, title?: string, display_all?: ''|'checked', include_childless_parent?: ''|'checked', include_parent?: ''|'checked', levels: int|numeric-string, post_type?: string, display_everywhere?: string, parent_page?: int|numeric-string, display-posts?: string, new_widget: 'list'|'widget', single: ''|'checked', taxonomy?: string, localized: true}", $union );
	}
}
