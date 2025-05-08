<?php

declare( strict_types=1 );

namespace SzepeViktor\PHPStan\WordPress\Tests;

use function PHPStan\Testing\assertType;

assertType( 'WP_Term|false', get_term_by( 'term_id', 2, '', OBJECT ) );
assertType( 'WP_Term|false', get_term_by( 'slug', 'test' ) );
assertType( 'array<string, int|string>|false', get_term_by( 'term_id', 2, '', ARRAY_A ) );
assertType( 'list<int|string>|false', get_term_by( 'term_id', 2, '', ARRAY_N ) );
