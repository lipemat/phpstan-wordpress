<?php
/** @noinspection GrazieInspection */

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Rules;

final class NoCompactRuleTest extends AbstractTestCase {
	private static $message = "Function compact() should not be used.\n    💡 Using the `compact` function prevents static analysis. Consider declaring an associative array instead.";

	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'compact-not-used' => __DIR__ . '/../../../fixtures/Expressions/NoCompactRule/Success/compact-not-used.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'compact-used-with-alias'          => [
				__DIR__ . '/../../../fixtures/Expressions/NoCompactRule/Failure/compact-used-with-alias.php',
				[
					self::$message,
					12,
				],
			],
			'compact-used-with-correct-case'   => [
				__DIR__ . '/../../../fixtures/Expressions/NoCompactRule/Failure/compact-used-with-correct-case.php',
				[
					self::$message,
					10,
				],
			],
			'compact-used-with-incorrect-case' => [
				__DIR__ . '/../../../fixtures/Expressions/NoCompactRule/Failure/compact-used-with-incorrect-case.php',
				[
					self::$message,
					10,
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
		return new NoCompactRule();
	}
}
