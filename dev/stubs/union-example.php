<?php
declare( strict_types=1 );

/**
 * Required to be loaded before the UnionExample class
 * so PHPStan can resolve type aliases.
 *
 * A special requirement because the class is using @phpstan-type
 *
 * @see UnionTest
 */

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver {

	/**
	 * @phpstan-type EXPORTED array{
	 *      exclude: string,
	 *      order_by: string,
	 *      title?: string,
	 *      display_all?: ''|'checked',
	 *      include_childless_parent?: ''|'checked',
	 *      include_parent?: ''|'checked',
	 *      levels?: numeric-string|int,
	 *      post_type?: string,
	 * }
	 *
	 */
	class DataHolder {

	}

	/**
	 * @phpstan-import-type EXPORTED from DataHolder
	 *
	 * @phpstan-type IMPORTED Union<EXPORTED, array{
	 *     display_everywhere?: string,
	 *     parent_page?: numeric-string|int
	 * }>
	 *
	 * @phpstan-type LOCAL array{
	 *      'display-posts'?: string,
	 *      exclude: string,
	 *      include_childless_parent?: ''|'checked',
	 *      include_parent?: ''|'checked',
	 *      levels: numeric-string|int,
	 *      new_widget: 'widget'|'list',
	 *      single: ''|'checked',
	 *      taxonomy?: string,
	 *      title?: string,
	 *      order_by: string|int,
	 * }
	 */
	class UnionExample {

	}
}
