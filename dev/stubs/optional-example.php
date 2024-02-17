<?php
declare( strict_types=1 );

/**
 * Optional to be loaded before the OptionalExample class
 * so PHPStan can resolve type aliases.
 *
 * A special requirement because the class is using @phpstan-type
 *
 * @see OptionalTest
 */

namespace Lipe\Lib\Phpstan\Services\TypeNodeResolver {

	/**
	 * @phpstan-type DATA array{
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
	class OptionalDataHolder {

	}

	/**
	 * @phpstan-import-type DATA from OptionalDataHolder
	 *
	 */
	class OptionalExample {
	}
}
