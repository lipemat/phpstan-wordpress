<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoConstructorParameterWithDefaultValueRule\Success;

trait MethodInTraitWithParameterWithDefaultValue
{
    public function foo($bar = 9000): void
    {
    }
}
