<?php

declare(strict_types=1);

namespace Lipe\Lib\Phpstan\Rules\Classes;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRule\Failure\ClassExtendingOtherClass;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRule\Failure\OtherClass;
use PHPStan\Rules;

final class NoExtendsRuleTest extends AbstractTestCase {
	use \StaticRule;
    public static function provideCasesWhereAnalysisShouldSucceed(): iterable
    {
        $paths = [
            'class' => __DIR__ . '/../../../fixtures/Classes/NoExtendsRule/Success/ExampleClass.php',
            'class-extending-php-unit-framework-test-case' => __DIR__ . '/../../../fixtures/Classes/NoExtendsRule/Success/ClassExtendingPhpUnitFrameworkTestCase.php',
            'interface' => __DIR__ . '/../../../fixtures/Classes/NoExtendsRule/Success/ExampleInterface.php',
            'interface-extending-other-interface' => __DIR__ . '/../../../fixtures/Classes/NoExtendsRule/Success/InterfaceExtendingOtherInterface.php',
            'script-with-anonymous-class' => __DIR__ . '/../../../fixtures/Classes/NoExtendsRule/Success/anonymous-class.php',
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
            'class-extending-other-class' => [
                __DIR__ . '/../../../fixtures/Classes/NoExtendsRule/Failure/ClassExtendingOtherClass.php',
                [
                    \sprintf(
                        'Class "%s" is not allowed to extend "%s".',
                        ClassExtendingOtherClass::class,
                        OtherClass::class
                    ),
                    7,
                ],
            ],
            'script-with-anonymous-class-extending-other-class' => [
                __DIR__ . '/../../../fixtures/Classes/NoExtendsRule/Failure/anonymous-class-extending-other-class.php',
                [
                    \sprintf(
                        'Anonymous class is not allowed to extend "%s".',
                        OtherClass::class
                    ),
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


	protected function getRule(): Rules\Rule {
		return self::staticRule( new NoExtendsRule( [] ) );
    }
}
