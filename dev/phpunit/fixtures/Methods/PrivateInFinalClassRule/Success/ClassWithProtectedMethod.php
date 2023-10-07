<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\PrivateInFinalClassRule\Success;

class ClassWithProtectedMethod
{
    protected function method(): void
    {
    }
}
