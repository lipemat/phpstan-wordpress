<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\PrivateInFinalClassRule\Success;

final class FinalClassWithPublicMethod
{
    public function method(): void
    {
    }
}
