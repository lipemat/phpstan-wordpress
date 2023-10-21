<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Classes;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure\AbstractClass;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure\NeitherAbstractNorFinalClass;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure\NonFinalClassWithoutEntityAnnotationInInlineDocBlock;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure\NonFinalClassWithoutEntityAnnotationInMultilineDocBlock;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure\NonFinalClassWithoutOrmEntityAnnotationInInlineDocBlock;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\FinalRule\Failure\NonFinalClassWithoutOrmEntityAnnotationInMultilineDocBlock;
use PHPStan\Rules;

final class FinalRuleTest extends AbstractTestCase {
	use \StaticRule;

	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'final-class'                                                                => __DIR__ . '/../../../fixtures/Classes/FinalRule/Success/FinalClass.php',
			'final-class-with-anonymous-class'                                           => __DIR__ . '/../../../fixtures/Classes/FinalRule/Success/FinalClassWithAnonymousClass.php',
			'interface'                                                                  => __DIR__ . '/../../../fixtures/Classes/FinalRule/Success/ExampleInterface.php',
			'script-with-anonymous-class'                                                => __DIR__ . '/../../../fixtures/Classes/FinalRule/Success/anonymous-class.php',
			'trait'                                                                      => __DIR__ . '/../../../fixtures/Classes/FinalRule/Success/ExampleTrait.php',
			'trait-with-anonymous-class'                                                 => __DIR__ . '/../../../fixtures/Classes/FinalRule/Success/TraitWithAnonymousClass.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'abstract-class'                                                        => [
				__DIR__ . '/../../../fixtures/Classes/FinalRule/Failure/AbstractClass.php',
				[
					\sprintf(
						'Class %s is not an allowed abstract.',
						AbstractClass::class
                    ),
					7,
				],
			],
			'neither-abstract-nor-final-class'                                      => [
				__DIR__ . '/../../../fixtures/Classes/FinalRule/Failure/NeitherAbstractNorFinalClass.php',
				[
					\sprintf(
						'Class %s is not final.',
						NeitherAbstractNorFinalClass::class
                    ),
					7,
				],
			],
			'non-final-class-without-entity-annotation-in-inline-doc-block'         => [
				__DIR__ . '/../../../fixtures/Classes/FinalRule/Failure/NonFinalClassWithoutEntityAnnotationInInlineDocBlock.php',
				[
					\sprintf(
						'Class %s is not final.',
						NonFinalClassWithoutEntityAnnotationInInlineDocBlock::class
                    ),
					8,
				],
			],
			'non-final-class-without-entity-annotation-in-multi-line-doc-block'     => [
				__DIR__ . '/../../../fixtures/Classes/FinalRule/Failure/NonFinalClassWithoutEntityAnnotationInMultilineDocBlock.php',
				[
					\sprintf(
						'Class %s is not final.',
						NonFinalClassWithoutEntityAnnotationInMultilineDocBlock::class
                    ),
					12,
				],
			],
			'non-final-class-without-orm-entity-annotation-in-inline-doc-block'     => [
				__DIR__ . '/../../../fixtures/Classes/FinalRule/Failure/NonFinalClassWithoutOrmEntityAnnotationInInlineDocBlock.php',
				[
					\sprintf(
						'Class %s is not final.',
						NonFinalClassWithoutOrmEntityAnnotationInInlineDocBlock::class
                    ),
					8,
				],
			],
			'non-final-class-without-orm-entity-annotation-in-multi-line-doc-block' => [
				__DIR__ . '/../../../fixtures/Classes/FinalRule/Failure/NonFinalClassWithoutOrmEntityAnnotationInMultilineDocBlock.php',
				[
					\sprintf(
						'Class %s is not final.',
						NonFinalClassWithoutOrmEntityAnnotationInMultilineDocBlock::class
                    ),
					12,
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
		return self::staticRule( new FinalRule( true, [] ) );
	}
}
