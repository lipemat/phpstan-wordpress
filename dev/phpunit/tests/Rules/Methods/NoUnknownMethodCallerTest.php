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
final class NoUnknownMethodCallerTest extends AbstractTestCase {

	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'skip-known-caller-type' => __DIR__ . '/../../../fixtures/Methods/NoUnknownMethodCallerRule/Success/SkipKnownCallerType.php',
			'skip-mock-object'       => __DIR__ . '/../../../fixtures/Methods/NoUnknownMethodCallerRule/Success/SkipMockObject.php',
			'skip-phpunit-mock'      => __DIR__ . '/../../../fixtures/Methods/NoUnknownMethodCallerRule/Success/SkipPHPUnitMock.php',
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
				__DIR__ . '/../../../fixtures/Methods/NoUnknownMethodCallerRule/Failure/MagicMethodName.php',
				[
					\sprintf( NoUnknownMethodCallerRule::ERROR_MESSAGE, 'magic', '$someType' ) . '
    💡 Try checking `instanceof` first.',
					11,
				],
			],

			'unknown-caller-type' => [
				__DIR__ . '/../../../fixtures/Methods/NoUnknownMethodCallerRule/Failure/UnknownCallerType.php',
				[
					sprintf( NoUnknownMethodCallerRule::ERROR_MESSAGE, 'call', '$mixedType' ) . '
    💡 Try checking `instanceof` first.',
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
		return new NoUnknownMethodCallerRule();
	}
}
