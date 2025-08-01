<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Expressions\NoExtractRule\Failure;

use function extract as variables;

$data = [
	'foo' => 9000,
	'bar' => 42,
];

variables( $data );

return $foo + $bar;
