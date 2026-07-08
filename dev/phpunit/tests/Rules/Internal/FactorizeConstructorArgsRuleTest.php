<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Internal;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Test;
use PHPStan\Rules;

final class FactorizeConstructorArgsRuleTest extends AbstractTestCase {
	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		yield 'valid-factorize-calls' => [
			__DIR__ . '/../../../fixtures/Internal/FactorizeConstructorArgsRule/Success/ValidFactorizeCalls.php',
		];
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		yield 'wrong-argument-type' => [
			__DIR__ . '/../../../fixtures/Internal/FactorizeConstructorArgsRule/Failure/WrongArgumentType.php',
			[
				\sprintf(
					'Parameter #1 $id of %s::__construct() expects int, string given.',
					Test\Fixture\Internal\FactorizeConstructorArgsRule\Failure\WrongArgumentType::class
				),
				17,
			],
		];

		yield 'too-many-arguments' => [
			__DIR__ . '/../../../fixtures/Internal/FactorizeConstructorArgsRule/Failure/TooManyArguments.php',
			[
				\sprintf(
					'%1$s::factorize() passes 2 argument(s) to %1$s::__construct() which expects 1 argument(s).',
					Test\Fixture\Internal\FactorizeConstructorArgsRule\Failure\TooManyArguments::class
				),
				17,
			],
		];
	}


	protected function getRule(): Rules\Rule {
		return new FactorizeConstructorArgsRule();
	}
}
