<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRuleWithClassesAllowedToBeExtended\Failure;

$foo = new class() extends OtherClass {
    public function __toString(): string
    {
        return 'Hmm';
    }
};
