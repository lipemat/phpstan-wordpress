<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Expressions;
use PHPStan\Rules;

final class NoEvalRuleTest extends AbstractTestCase
{
    public static function provideCasesWhereAnalysisShouldSucceed(): iterable
    {
        $paths = [
            'eval-not-used' => __DIR__ . '/../../../fixtures/Expressions/NoEvalRule/Success/eval-not-used.php',
        ];

        foreach ($paths as $description => $path) {
            yield $description => [
                $path,
            ];
        }
    }

    public static function provideCasesWhereAnalysisShouldFail(): iterable
    {
        $paths = [
            'eval-used-with-correct-case' => [
                __DIR__ . '/../../../fixtures/Expressions/NoEvalRule/Failure/eval-used-with-correct-case.php',
                [
                    'Language construct eval() should not be used.',
                    7,
                ],
            ],
            'eval-used-with-incorrect-case' => [
                __DIR__ . '/../../../fixtures/Expressions/NoEvalRule/Failure/eval-used-with-incorrect-case.php',
                [
                    'Language construct eval() should not be used.',
                    7,
                ],
            ],
        ];

        foreach ($paths as $description => [$path, $error]) {
            yield $description => [
                $path,
                $error,
            ];
        }
    }

    protected function getRule(): Rules\Rule
    {
        return new Expressions\NoEvalRule();
    }
}
