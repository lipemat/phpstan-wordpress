<?php
declare( strict_types=1 );

namespace Rules\Statements;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Statements\NoIssetOnObjectRule;
use PHPStan\Rules\Rule;

/**
 * @author Mat Lipe
 * @since  July 2024
 *
 */
final class NoIssetOnObjectRuleTest extends AbstractTestCase {

	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'skip-isset-on-array'                  => __DIR__ . '/../../../fixtures/Statements/NoIssetOnObjectRule/Success/SkipIssetOnArray.php',
			'skip-isset-on-array-nested-on-object' => __DIR__ . '/../../../fixtures/Statements/NoIssetOnObjectRule/Success/SkipIssetOnArrayNestedOnObject.php',
			'skip-possible-undefined-variable'     => __DIR__ . '/../../../fixtures/Statements/NoIssetOnObjectRule/Success/SkipPossibleUndefinedVariable.php',
			'skip-isset-on-property-fetch'         => __DIR__ . '/../../../fixtures/Statements/NoIssetOnObjectRule/Success/SkipIssetOnPropertyFetch.php',
		];
		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'isset-on-object' =>
				[
					__DIR__ . '/../../../fixtures/Statements/NoIssetOnObjectRule/Failure/IssetOnObject.php',
					[ NoIssetOnObjectRule::ERROR_MESSAGE, 17 ],
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
		return new NoIssetOnObjectRule();
	}
}
