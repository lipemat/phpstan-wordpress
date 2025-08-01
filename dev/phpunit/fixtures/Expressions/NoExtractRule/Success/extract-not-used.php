<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Expressions\NoExtractRule\Success;

function _extract(array $array): array
{
    return $array;
}

$data = [
    'foo' => 9000,
    'bar' => 42,
];

return _extract($data);
