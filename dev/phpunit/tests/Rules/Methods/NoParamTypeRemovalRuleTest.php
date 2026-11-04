<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Rules;

final class NoParamTypeRemovalRuleTest extends AbstractTestCase {
	use \StaticRule;

	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$success = __DIR__ . '/../../../fixtures/Methods/NoParamTypeRemovalRule/Success/';

		$names = [
			'kept-param-types'             => 'KeptParamTypes',
			'new-method'                   => 'NewMethod',
			'parent-with-mixed-param-type' => 'ParentWithMixedParamType',
			'parent-without-param-type'    => 'ParentWithoutParamType',
			'typed-parent'                 => 'TypedParent',
		];

		foreach ( $names as $description => $name ) {
			yield $description => [
				$success . $name . '.php',
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$failure = __DIR__ . '/../../../fixtures/Methods/NoParamTypeRemovalRule/Failure/';

		$names = [
			'removed-class-type'                 => [ 'RemovedClassType', 10 ],
			'removed-every-param-type'           => [ 'RemovedEveryParamType', 10 ],
			'removed-imported-class-type'        => [ 'RemovedImportedClassType', 11 ],
			'removed-intersection-type'          => [ 'RemovedIntersectionType', 10 ],
			'removed-nullable-intersection-type' => [ 'RemovedNullableIntersectionType', 10 ],
			'removed-nullable-type'              => [ 'RemovedNullableType', 10 ],
			'removed-nullable-union-type'        => [ 'RemovedNullableUnionType', 10 ],
			'removed-scalar-type'                => [ 'RemovedScalarType', 10 ],
			'removed-second-param-type'          => [ 'RemovedSecondParamType', 12 ],
			'removed-self-type'                  => [ 'RemovedSelfType', 10 ],
			'removed-union-type'                 => [ 'RemovedUnionType', 10 ],
		];

		foreach ( $names as $description => [$name, $line] ) {
			yield $description => [
				$failure . $name . '.php',
				[
					NoParamTypeRemovalRule::ERROR_MESSAGE,
					$line,
				],
			];
		}
	}


	public static function provideCasesWithFixes(): iterable {
		$failure = __DIR__ . '/../../../fixtures/Methods/NoParamTypeRemovalRule/Failure/';
		$fixed = __DIR__ . '/../../../fixtures/Methods/NoParamTypeRemovalRule/Fixed/';

		$names = [
			'removed-class-type'                 => 'RemovedClassType',
			'removed-every-param-type'           => 'RemovedEveryParamType',
			'removed-imported-class-type'        => 'RemovedImportedClassType',
			'removed-intersection-type'          => 'RemovedIntersectionType',
			'removed-nullable-intersection-type' => 'RemovedNullableIntersectionType',
			'removed-nullable-type'              => 'RemovedNullableType',
			'removed-nullable-union-type'        => 'RemovedNullableUnionType',
			'removed-scalar-type'                => 'RemovedScalarType',
			'removed-second-param-type'          => 'RemovedSecondParamType',
			'removed-self-type'                  => 'RemovedSelfType',
			'removed-union-type'                 => 'RemovedUnionType',
		];

		foreach ( $names as $description => $name ) {
			yield $description => [
				$failure . $name . '.php',
				$fixed . $name . '.php',
			];
		}
	}


	protected function getRule(): Rules\Rule {
		return self::staticRule( new NoParamTypeRemovalRule() );
	}
}
