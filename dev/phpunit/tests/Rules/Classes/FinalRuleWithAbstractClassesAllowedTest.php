<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Classes;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRuleWithAbstractClassesAllowed\Failure\NeitherAbstractNorFinalClass;
use PHPStan\Rules;

final class FinalRuleWithAbstractClassesAllowedTest extends AbstractTestCase {
	use \StaticRule;
	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'abstract-class'                   => __DIR__ . '/../../../fixtures/Classes/FinalRuleWithAbstractClassesAllowed/Failure/AbstractClass.php',
			'final-class'                      => __DIR__ . '/../../../fixtures/Classes/FinalRuleWithAbstractClassesAllowed/Success/FinalClass.php',
			'final-class-with-anonymous-class' => __DIR__ . '/../../../fixtures/Classes/FinalRuleWithAbstractClassesAllowed/Success/FinalClassWithAnonymousClass.php',
			'interface'                        => __DIR__ . '/../../../fixtures/Classes/FinalRuleWithAbstractClassesAllowed/Success/ExampleInterface.php',
			'script-with-anonymous-class'      => __DIR__ . '/../../../fixtures/Classes/FinalRuleWithAbstractClassesAllowed/Success/anonymous-class.php',
			'trait'                            => __DIR__ . '/../../../fixtures/Classes/FinalRuleWithAbstractClassesAllowed/Success/ExampleTrait.php',
			'trait-with-anonymous-class'       => __DIR__ . '/../../../fixtures/Classes/FinalRuleWithAbstractClassesAllowed/Success/TraitWithAnonymousClass.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'neither-abstract-nor-final-class' => [
				__DIR__ . '/../../../fixtures/Classes/FinalRuleWithAbstractClassesAllowed/Failure/NeitherAbstractNorFinalClass.php',
				[
					\sprintf(
						'Class %s is neither abstract nor final.',
						NeitherAbstractNorFinalClass::class
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
		return self::staticRule( new FinalRule( false, [] ) );
	}
}
