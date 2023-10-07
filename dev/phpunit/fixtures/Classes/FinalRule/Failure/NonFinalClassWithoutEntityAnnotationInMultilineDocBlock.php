<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure;

/**
 * @Table(name="hmm")
 *
 * @eNtItY
 */
class NonFinalClassWithoutEntityAnnotationInMultilineDocBlock
{
}
