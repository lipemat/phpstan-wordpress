<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Success;

use WP_REST_Request;

final class ReadingAllowed {
	/**
	 * @param WP_REST_Request<array{fook: bool, other: string}> $request
	 */
	public function nothing( WP_REST_Request $request ): string {
		return $request['other'];
	}
}
