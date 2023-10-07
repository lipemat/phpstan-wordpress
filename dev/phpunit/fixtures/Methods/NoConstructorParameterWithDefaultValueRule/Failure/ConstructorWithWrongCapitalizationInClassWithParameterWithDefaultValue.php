<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoConstructorParameterWithDefaultValueRule\Failure;

final class ConstructorWithWrongCapitalizationInClassWithParameterWithDefaultValue
{
    public function __CoNsTrUcT($bar = 9000)
    {
    }
}
