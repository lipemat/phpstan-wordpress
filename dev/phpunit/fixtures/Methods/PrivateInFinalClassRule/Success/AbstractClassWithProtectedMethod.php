<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\PrivateInFinalClassRule\Success;

abstract class AbstractClassWithProtectedMethod
{
    protected function method(): void
    {
    }
}
