<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Expressions;
use PHPStan\Rules;

final class NoErrorSuppressionRuleTest extends AbstractTestCase
{
    public static function provideCasesWhereAnalysisShouldSucceed(): iterable
    {
        $paths = [
            'error-suppression-not-used' => __DIR__ . '/../../../fixtures/Expressions/NoErrorSuppressionRule/Success/error-suppression-not-used.php',
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
            'error-suppression-used' => [
                __DIR__ . '/../../../fixtures/Expressions/NoErrorSuppressionRule/Failure/error-suppression-used.php',
                [
                    'Error suppression via "@" should not be used.',
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
        return new Expressions\NoErrorSuppressionRule();
    }
}
