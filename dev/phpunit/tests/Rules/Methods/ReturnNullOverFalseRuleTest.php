<?php
declare( strict_types=1 );

namespace Rules\Methods;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Methods\ReturnNullOverFalseRule;
use PHPStan\Rules\Rule;

/**
 * @author Mat Lipe
 * @since  July 2024
 *
 */
final class ReturnNullOverFalseRuleTest extends AbstractTestCase {
	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'check-result-from-other-method'   => [
				__DIR__ . '/../../../fixtures/Methods/ReturnNullOverFalseRule/Success/CheckResultFromOtherMethod.php',
				[],
			],
			'check-result-from-other-method-2' => [
				__DIR__ . '/../../../fixtures/Methods/ReturnNullOverFalseRule/Success/CheckResultFromOtherMethod2.php',
				[],
			],
			'skip-return-bool'                 => [
				__DIR__ . '/../../../fixtures/Methods/ReturnNullOverFalseRule/Success/SkipReturnBool.php',
				[],
			],
		];

		foreach ( $paths as $description => [$path, $error] ) {
			yield $description => [
				$path,
				$error,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'return-false-only' => [
				__DIR__ . '/../../../fixtures/Methods/ReturnNullOverFalseRule/Failure/ReturnFalseOnly.php',
				[ ReturnNullOverFalseRule::ERROR_MESSAGE, 9 ],
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
		return new ReturnNullOverFalseRule();
	}
}
