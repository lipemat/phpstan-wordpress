<?php

declare( strict_types=1 );

namespace SzepeViktor\PHPStan\WordPress\Tests;

use function PHPStan\Testing\assertType;

assertType( 'bool|int|string', ( new \WP_Widget( '', '' ) )->number );
