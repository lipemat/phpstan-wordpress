<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRuleWithClassesAllowedToBeExtended\Success;

use PHPUnit\Framework;

#[Framework\Attributes\CoversNothing]
final class ClassExtendingPhpUnitFrameworkTestCase extends Framework\TestCase
{
}
