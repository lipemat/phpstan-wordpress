<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Classes;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRuleWithWhiteListedAbstractClassNames\Failure\NeitherAbstractNorFinalClass;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRuleWithWhiteListedAbstractClassNames\Failure\UnlistedAbstractClass;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRuleWithWhiteListedAbstractClassNames\Success\AbstractAndWhitelisted;
use PHPStan\Rules;

final class FinalRuleWithWhiteListedAbstractClassNamesTest extends AbstractTestCase {
	use \StaticRule;

	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$path = __DIR__ . '/../../../fixtures/Classes/FinalRuleWithWhiteListedAbstractClassNames/Success/';
		$paths = [
			'abstract-and-whitelisted'         => $path . 'AbstractAndWhitelisted.php',
			'final-class'                      => $path . 'FinalClass.php',
			'final-class-with-anonymous-class' => $path . 'FinalClassWithAnonymousClass.php',
			'interface'                        => $path . 'ExampleInterface.php',
			'script-with-anonymous-class'      => $path . 'anonymous-class.php',
			'trait'                            => $path . 'ExampleTrait.php',
			'trait-with-anonymous-class'       => $path . 'TraitWithAnonymousClass.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$path = __DIR__ . '/../../../fixtures/Classes/FinalRuleWithWhiteListedAbstractClassNames/Failure/';

		$paths = [
			'abstract-class'                   => [
				$path . 'UnlistedAbstractClass.php',
				[
					\sprintf(
						'Class %s is not an allowed abstract.',
						UnlistedAbstractClass::class
					),
					7,
				],
			],
			'neither-abstract-nor-final-class' => [
				$path . 'NeitherAbstractNorFinalClass.php',
				[
					\sprintf(
						'Class %s is not final.',
						NeitherAbstractNorFinalClass::class
					),
					7,
				],
			],
			'final-class-checking-for-message' => [
				__DIR__ . '/../../../fixtures/Classes/FinalRule/Failure/NeitherAbstractNorFinalClass.php',
				[
					\sprintf(
						'Class %s is not final.',
						\Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure\NeitherAbstractNorFinalClass::class
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
		return self::staticRule( new FinalRule( true, [
				AbstractAndWhitelisted::class,
			]
		) );
	}
}
