<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Rules\Rule;

final class NoSwitchRuleTest extends AbstractTestCase {
	use \StaticRule;

	private static $message = "Control structures using `switch` should not be used.\n    💡 The `switch` statement uses loose comparison.";


	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'isset-used' => __DIR__ . '/../../../fixtures/Statements/NoSwitchRule/Success/switch-not-used.php',
			'match-used' => __DIR__ . '/../../../fixtures/Statements/NoSwitchRule/Success/match-used.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		if ( PHP_VERSION_ID >= 80000 ) {
			$message = self::$message . 'Consider using a `match` statement instead.';
		} else {
			$message = self::$message;
		}

		$paths = [
			'switch-used-with-correct-case'   => [
				__DIR__ . '/../../../fixtures/Statements/NoSwitchRule/Failure/switch-used-with-correct-case.php',
				[
					$message,
					5,
				],
			],
			'switch-used-with-incorrect-case' => [
				__DIR__ . '/../../../fixtures/Statements/NoSwitchRule/Failure/switch-used-with-incorrect-case.php',
				[
					$message,
					5,
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


	protected function getRule(): Rule {
		return self::staticRule( new NoSwitchRule() );
	}

}
