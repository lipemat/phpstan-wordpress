<?php
/** @noinspection GrazieInspection */

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Expressions;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Rules;

final class NoCompactRuleTest extends AbstractTestCase {
	use \StaticRule;

	private static string $message = "Function compact() should not be used.\n    💡 Using the `compact` function prevents static analysis. Consider declaring an associative array instead.";

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
			'compact-used-with-array-of-names'  => [
				__DIR__ . '/../../../fixtures/Expressions/NoCompactRule/Failure/compact-used-with-array-of-names.php',
				[
					self::$message,
					10,
				],
			],
			'compact-used-with-named-argument'  => [
				__DIR__ . '/../../../fixtures/Expressions/NoCompactRule/Failure/compact-used-with-named-argument.php',
				[
					self::$message,
					9,
				],
			],
			'compact-used-with-spread-names'    => [
				__DIR__ . '/../../../fixtures/Expressions/NoCompactRule/Failure/compact-used-with-spread-names.php',
				[
					self::$message,
					11,
				],
			],
			'compact-used-with-undefined-variable' => [
				__DIR__ . '/../../../fixtures/Expressions/NoCompactRule/Failure/compact-used-with-undefined-variable.php',
				[
					self::$message,
					9,
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


	public static function provideCasesWithFixes(): iterable {
		yield from self::fixCases( 'Expressions/NoCompactRule', [
			'compact-used-with-alias',
			'compact-used-with-correct-case',
			'compact-used-with-incorrect-case',
		] );

		// Names this rule cannot resolve to known variables carry no fix.
		yield from self::fixCases( 'Expressions/NoCompactRule', [
			'compact-used-with-array-of-names',
			'compact-used-with-named-argument',
			'compact-used-with-spread-names',
			'compact-used-with-undefined-variable',
		], 'Failure' );
	}


	protected function getRule(): Rules\Rule {
		return self::staticRule( new NoCompactRule() );
	}
}
