<?php

namespace {
	const WPCOM_IS_VIP_ENV = false;

	function vip_safe_wp_remote_get( string $url, $fallback_value = '', $threshold = 3, $timeout = 1, $retry = 20, $args = [] ) {
	}

	function vip_reset_db_query_log() : void {
	}

	function vip_reset_local_object_cache() : void {
	}

	function jetpack_is_mobile( string $kind = 'any', bool $return_matched_agent = false ) {
	}
}