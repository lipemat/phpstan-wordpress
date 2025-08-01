<?php
/** @noinspection GrazieInspection */

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Rules;

final class NoExtractRuleTest extends AbstractTestCase {
	use \StaticRule;

	private static $message = "Function extract() should not be used.\n    💡 Using the `extract` function creates variables dynamically which prevents static analysis. Consider using array access or destructuring instead.";


	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'extract-not-used' => __DIR__ . '/../../../fixtures/Expressions/NoExtractRule/Success/extract-not-used.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'extract-used-with-alias'          => [
				__DIR__ . '/../../../fixtures/Expressions/NoExtractRule/Failure/extract-used-with-alias.php',
				[
					self::$message,
					14,
				],
			],
			'extract-fully-qualified'          => [
				__DIR__ . '/../../../fixtures/Expressions/NoExtractRule/Failure/extract-fully-qualified.php',
				[
					self::$message,
					12,
				],
			],
			'extract-not-qualified'            => [
				__DIR__ . '/../../../fixtures/Expressions/NoExtractRule/Failure/extract-not-qualified.php',
				[
					self::$message,
					12,
				],
			],
			'extract-used-with-incorrect-case' => [
				__DIR__ . '/../../../fixtures/Expressions/NoExtractRule/Failure/extract-used-with-incorrect-case.php',
				[
					self::$message,
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
		return self::staticRule( new NoExtractRule() );
	}
}
