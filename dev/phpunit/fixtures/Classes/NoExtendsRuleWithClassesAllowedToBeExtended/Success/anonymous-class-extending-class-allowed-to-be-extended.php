<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRuleWithClassesAllowedToBeExtended\Success;

$foo = new class() extends ClassAllowedToBeExtended {
    public function __toString(): string
    {
        return 'Hmm';
    }
};
