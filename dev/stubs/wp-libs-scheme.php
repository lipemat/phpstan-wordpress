<?php

namespace Lipe\Project\Security\Plugin_Endpoint {

	use Lipe\Lib\Schema\Db;

	class TestDb extends Db {
		public const COLUMNS = [
			'user_id'      => '%d',
			'content_id'   => '%s',
			'content_type' => '%s',
			'amount'       => '%f',
			'date'         => '%s',
		];
	}
}

namespace Lipe\Lib\Schema {

	/**
	 * @phpstan-type WHERE array<string,float|string|null>|int
	 */
	abstract class Db {
		/**
		 * Retrieve data from this db table.
		 *
		 * Automatically maps the results to a single value or row if the
		 * `$count` is set to 1.
		 *
		 * @phpstan-param WHERE        $id_or_wheres
		 *
		 * @param array<string>|string $columns      Array or CSV of columns we want to return.
		 *                                           Pass '*' to return all columns.
		 *
		 * @param array|int            $id_or_wheres Row id or array or where column => value.
		 *                                           Adding a % within the value will turn the
		 *                                           query into a `LIKE` query.
		 *
		 * @param int|string           $count        Number of rows to return. An offset may also be
		 *                                           provided via `<offset>,<limit>` for pagination.
		 *                                           If set to 1 this will return a single value or row
		 *                                           instead of an array.
		 *
		 * @param string|null          $order_by     An ORDERBY column and direction.
		 *                                           Optionally pass `ASC` or `DESC` after the
		 *                                           column to specify direction.
		 *
		 * @return null|object|array<object>|\stdClass|string|array<string>
		 */
		public function get( $columns, $id_or_wheres = null, $count = null, string $order_by = null ) {
		}
	}
}
