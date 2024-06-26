<?php
declare( strict_types=1 );

/**
 * Required to be loaded before the ExcludeExample class
 * so PHPStan can resolve type aliases.
 *
 * A special requirement because the class is using @phpstan-type
 *
 * @see ExcludeTest
 */

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver {

	/**
	 * @phpstan-type EXCLUDE_DATA array{
	 *      exclude: string,
	 *      order_by: string,
	 *      title?: string,
	 *      display_all?: ''|'checked',
	 *      include_childless_parent?: ''|'checked',
	 *      include_parent?: ''|'checked',
	 *      levels?: numeric-string|int,
	 *      post_type?: string,
	 * }
	 */
	class ExcludeDataHolder {

	}

	/**
	 * @phpstan-import-type EXCLUDE_DATA from ExcludeDataHolder
	 *
	 */
	class ExcludeExample {
	}
}
