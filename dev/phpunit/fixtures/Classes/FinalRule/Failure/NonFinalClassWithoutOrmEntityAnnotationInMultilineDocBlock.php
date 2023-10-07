<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure;

/**
 * @ORM\Table(name="hmm")
 *
 * @OrM\eNtItY
 */
class NonFinalClassWithoutOrmEntityAnnotationInMultilineDocBlock
{
}
