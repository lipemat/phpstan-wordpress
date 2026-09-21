<?php

declare( strict_types=1 );

use function PHPStan\Testing\assertType;

assertType( 'array<int, WP_Comment>', get_approved_comments( 1 ) );

assertType( 'int<0, max>', get_approved_comments( 1, [
	'count' => true,
] ) );
assertType( 'int<0, max>', get_approved_comments( 1, [
	'count'  => true,
	'fields' => 'ids',
] ) );
assertType( 'array<int, WP_Comment>', get_approved_comments( 1, [
	'count' => false,
] ) );
assertType( 'array<int<0, max>>', get_approved_comments( 1, [
	'fields' => 'ids',
] ) );
assertType( 'array<int<0, max>>', get_approved_comments( 1, [
	'count'  => false,
	'fields' => 'ids',
] ) );
