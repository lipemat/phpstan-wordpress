<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Classes;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRuleWithClassesAllowedToBeExtended\Failure\ClassExtendingOtherClass;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRuleWithClassesAllowedToBeExtended\Failure\OtherClass;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRuleWithClassesAllowedToBeExtended\Success\ClassAllowedToBeExtended;
use PHPStan\Rules;

final class NoExtendsRuleWithClassesAllowedToBeExtendedTest extends AbstractTestCase {
	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$path = __DIR__ . '/../../../fixtures/Classes/NoExtendsRuleWithClassesAllowedToBeExtended/Success/';
		$paths = [
			'class'                                                              => $path . 'ExampleClass.php',
			'class-extending-class-allowed-to-be-extended'                       => $path . 'ClassExtendingClassAllowedToBeExtended.php',
			'class-extending-php-unit-framework-test-case'                       => $path . 'ClassExtendingPhpUnitFrameworkTestCase.php',
			'class-extending-wp-block'                                           => $path . 'ClassExtendingWP_Block.php',
			'interface'                                                          => $path . 'ExampleInterface.php',
			'interface-extending-other-interface'                                => $path . 'InterfaceExtendingOtherInterface.php',
			'script-with-anonymous-class'                                        => $path . 'anonymous-class.php',
			'script-with-anonymous-class-extending-class-allowed-to-be-extended' => $path . 'anonymous-class-extending-class-allowed-to-be-extended.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'class-extending-other-class'                       => [
				__DIR__ . '/../../../fixtures/Classes/NoExtendsRuleWithClassesAllowedToBeExtended/Failure/ClassExtendingOtherClass.php',
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
				__DIR__ . '/../../../fixtures/Classes/NoExtendsRuleWithClassesAllowedToBeExtended/Failure/anonymous-class-extending-other-class.php',
				[
					\sprintf(
						'Anonymous class is not allowed to extend "%s".',
						OtherClass::class
					),
					7,
				],
			],
		];

		foreach ( $paths as $description => [$path, $error] ) {
			yield $description => [
				$path,
				$error,
			];
		}
	}


	protected function getRule(): Rules\Rule {
		return new NoExtendsRule( [
			ClassAllowedToBeExtended::class,
		] );
	}
}
