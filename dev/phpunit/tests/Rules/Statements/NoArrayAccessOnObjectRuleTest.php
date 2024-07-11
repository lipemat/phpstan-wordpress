<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Rules\Rule;

class NoArrayAccessOnObjectRuleTest extends AbstractTestCase {
	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'reading-allowed'           => __DIR__ . '/../../../fixtures/Statements/NoArrayAccessOnObjectRule/Success/ReadingAllowed.php',
			'skip-iterator'             => __DIR__ . '/../../../fixtures/Statements/NoArrayAccessOnObjectRule/Success/SkipIterator.php',
			'skip-on-array'             => __DIR__ . '/../../../fixtures/Statements/NoArrayAccessOnObjectRule/Success/SkipOnArray.php',
			'skip-spl-fixed-array'      => __DIR__ . '/../../../fixtures/Statements/NoArrayAccessOnObjectRule/Success/SkipSplFixedArray.php',
			'skip-xml'                  => __DIR__ . '/../../../fixtures/Statements/NoArrayAccessOnObjectRule/Success/SkipXml.php',
			'skip-xml-element-for-each' => __DIR__ . '/../../../fixtures/Statements/NoArrayAccessOnObjectRule/Success/SkipXmlElementForeach.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'array-access-on-object'        => [
				__DIR__ . '/../../../fixtures/Statements/NoArrayAccessOnObjectRule/Failure/ArrayAccessOnObject.php',
				[ NoArrayAccessOnObjectRule::ERROR_MESSAGE, 12 ],

			],
			'array-access-on-nested-object' => [
				__DIR__ . '/../../../fixtures/Statements/NoArrayAccessOnObjectRule/Failure/ArrayAccessOnNestedObject.php',

				[ NoArrayAccessOnObjectRule::ERROR_MESSAGE, 12 ],
			],
		];

		foreach ( $paths as $description => [$path, $error] ) {
			yield $description => [
				$path,
				$error,
			];
		}
	}


	protected function getRule(): Rule {
		return new NoArrayAccessOnObjectRule();
	}
}
