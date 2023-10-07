<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoConstructorParameterWithDefaultValueRule\Failure;

final class ConstructorInClassWithParameterWithDefaultValue
{
    public function __construct($bar = 9000)
    {
    }
}
