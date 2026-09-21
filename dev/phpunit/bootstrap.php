<?php

declare( strict_types=1 );

ini_set( 'memory_limit', '1G' );

require_once dirname( __DIR__, 2 ) . '/vendor/autoload.php';

require __DIR__ . '/stubs/Container/Factory.php';
require __DIR__ . '/helpers/StaticRule.php';
require __DIR__ . '/tests/Rules/AbstractTestCase.php';
