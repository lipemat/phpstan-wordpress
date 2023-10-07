<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\PrivateInFinalClassRule\Success;

final class FinalClassWithProtectedMethodExtendingClassExtendingClassWithSameProtectedMethod extends AbstractClassExtendingAbstractClassWithProtectedMethod
{
    protected function method(): void
    {
    }
}
