<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRule\Success;

$foo = new class() {
    public function __toString(): string
    {
        return 'Hmm';
    }
};
