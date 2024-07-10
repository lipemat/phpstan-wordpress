<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Rules\Rule;

/**
 * @author Mat Lipe
 * @since  July 2024
 *
 */
final class NoMixedMethodCallerRuleTest extends AbstractTestCase {

	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'skip-known-caller-type' => __DIR__ . '/../../../fixtures/Methods/NoMixedMethodCallerRule/Success/SkipKnownCallerType.php',
			'skip-mock-object'       => __DIR__ . '/../../../fixtures/Methods/NoMixedMethodCallerRule/Success/SkipMockObject.php',
			'skip-phpunit-mock'      => __DIR__ . '/../../../fixtures/Methods/NoMixedMethodCallerRule/Success/SkipPHPUnitMock.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'magic-method-name' => [
				__DIR__ . '/../../../fixtures/Methods/NoMixedMethodCallerRule/Failure/MagicMethodName.php',
				[
					\sprintf( NoMixedMethodCallerRule::ERROR_MESSAGE, '$someType' ),
					11,
				],
			],

			'unknown-caller-type' => [
				__DIR__ . '/../../../fixtures/Methods/NoMixedMethodCallerRule/Failure/UnknownCallerType.php',
				[
					sprintf( NoMixedMethodCallerRule::ERROR_MESSAGE, '$mixedType' ),
					11,
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


	/**
	 * @inheritDoc
	 */
	protected function getRule(): Rule {
		return new NoMixedMethodCallerRule();
	}
}
