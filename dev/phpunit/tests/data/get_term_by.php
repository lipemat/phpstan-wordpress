<?php

declare( strict_types=1 );

namespace SzepeViktor\PHPStan\WordPress\Tests;

use function PHPStan\Testing\assertType;

assertType( 'WP_Term|WP_Error', get_term_by( 'term_id', 2, '', OBJECT ) );
assertType( 'WP_Term|WP_Error', get_term_by( 'slug', 'test' ) );
assertType( 'array<string, mixed>|WP_Error', get_term_by( 'term_id', 2, '', ARRAY_A ) );
assertType( 'array<int, mixed>|WP_Error', get_term_by( 'term_id', 2, '', ARRAY_N ) );
