<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Expressions\NoExtractRule\Failure;

$data = [
	'foo' => 9000,
	'bar' => 42,
];

\extract( $data );

return $foo + $bar;
