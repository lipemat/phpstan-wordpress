<?php

namespace {
	const ABSPATH = '';
	const ADMIN_COOKIE_PATH = '';
	const AUTH_COOKIE = '';
	const AUTH_KEY = '';
	const AUTH_SALT = '';
	const DB_NAME = '';
	const DOMAIN_CURRENT_SITE = '';
	const COOKIEPATH = '';
	const COOKIE_DOMAIN = '';
	const LOGGED_IN_COOKIE = '';
	const LOGGED_IN_KEY = '';
	const LOGGED_IN_SALT = '';
	const NONCE_KEY = '';
	const NONCE_SALT = '';
	const PLUGINS_COOKIE_PATH = '';
	const SCRIPT_DEBUG = true;
	const SECURE_AUTH_COOKIE = '';
	const SECURE_AUTH_KEY = '';
	const SECURE_AUTH_SALT = '';
	const SITECOOKIEPATH = '';
	const WP_CONTENT_DIR = '';
	const WP_CONTENT_URL = '';
	const WPINC = '';
	const WP_PLUGIN_DIR = '';
	const WP_SITE_ROOT = '';

	/**
	 * Override the wordpress stubs which limit to 'header' and 'footer' parts.
	 *
	 * @link https://github.com/php-stubs/wordpress-stubs/issues/179
	 * @link https://core.trac.wordpress.org/ticket/60699
	 *
	 * @todo Remove once trac ticket 60699 is merged.
	 *
	 * @param string $part The block template part to print.
	 *
	 * @phpstan-return void
	 */
	function block_template_part( string $part ): void {
	}

	/**
	 * Override the wordpress stubs to support dynamic return type.
	 *
	 * @link https://github.com/php-stubs/wordpress-stubs/pull/180
	 *
	 * @todo Remove once pull request is released.
	 *
	 * @param string $ignore_class
	 *
	 * @param int    $skip_frames 0.
	 * @param bool   $pretty
	 *
	 * @return string|array Either a string containing a reversed comma separated trace or an array of individual calls.
	 * @phpstan-return ($pretty is true ? string : list<string>)
	 */
	function wp_debug_backtrace_summary( $ignore_class = \null, $skip_frames = 0, $pretty = \true ) {
	}

	/**
	 * Override for wordpress core phpdocs to fix return type.
	 *
	 * @link https://github.com/WordPress/wordpress-develop/pull/6654
	 * @link https://core.trac.wordpress.org/ticket/60699
	 *
	 * @todo Remove once trac ticket 60699 is merged.
	 *
	 * @param string $date      RFC3339 timestamp.
	 * @param bool   $force_utc Optional. Whether to force UTC timezone instead of using
	 *                          the timestamp's timezone. Default false.
	 *
	 * @return int|false Unix timestamp or false on failure.
	 */
	function rest_parse_date( $date, $force_utc = false ) {
	}
}
