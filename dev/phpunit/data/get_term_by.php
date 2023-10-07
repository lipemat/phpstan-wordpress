<?php

declare( strict_types=1 );

namespace SzepeViktor\PHPStan\WordPress\Tests;

use function PHPStan\Testing\assertType;

assertType( 'WP_Error|WP_Term|false', get_term_by( 'term_id', 2, '', OBJECT ) );
assertType( 'WP_Error|WP_Term|false', get_term_by( 'slug', 'test' ) );
assertType( 'array<string, int|string>|WP_Error|false', get_term_by( 'term_id', 2, '', ARRAY_A ) );
assertType( 'array<int, int|string>|WP_Error|false', get_term_by( 'term_id', 2, '', ARRAY_N ) );
