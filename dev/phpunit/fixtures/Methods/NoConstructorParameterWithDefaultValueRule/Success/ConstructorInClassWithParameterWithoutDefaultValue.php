<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoConstructorParameterWithDefaultValueRule\Success;

final class ConstructorInClassWithParameterWithoutDefaultValue
{
    public function __construct($bar)
    {
    }
}
