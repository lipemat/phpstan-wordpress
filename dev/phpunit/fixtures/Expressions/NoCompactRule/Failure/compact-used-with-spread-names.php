<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Expressions\NoCompactRule\Failure;

$foo = 9000;
$bar = 42;
$names = ['foo', 'bar'];

return \compact(
    ...$names,
);
