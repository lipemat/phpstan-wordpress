<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Failure;

use WP_REST_Request;

final class WritingNotAllowed {
	/**
	 * @param WP_REST_Request<array{fook: bool, other: string}> $request
	 */
	public function nothing( WP_REST_Request $request ): string {
		$request['write-me'] = 'not allowed';
		return $request['write-me'];
	}
}
