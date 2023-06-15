<?php

declare( strict_types=1 );

namespace SzepeViktor\PHPStan\WordPress\Tests;

use function PHPStan\Testing\assertType;

assertType( 'WP_Term|WP_Error', get_term( 2, '', OBJECT ) );
assertType( 'WP_Term|WP_Error', get_term( 2, 'category', OBJECT ) );
assertType( 'WP_Term|WP_Error', get_term( 2 ) );

assertType( 'array<string, mixed>|WP_Error', get_term( 2, '', ARRAY_A ) );
assertType( 'array<string, mixed>|WP_Error', get_term( 2, 'category', ARRAY_A ) );
assertType( 'array<int, mixed>|WP_Error', get_term( 2, '', ARRAY_N ) );
assertType( 'array<int, mixed>|WP_Error', get_term( 2, 'category', ARRAY_N ) );
