<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Test;
use PHPStan\Rules;

final class PrivateInFinalClassRuleTest extends AbstractTestCase {
	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'abstract-class-with-protected-method'                                                         => __DIR__ . '/../../../fixtures/Methods/PrivateInFinalClassRule/Success/AbstractClassWithProtectedMethod.php',
			'class-with-protected-method'                                                                  => __DIR__ . '/../../../fixtures/Methods/PrivateInFinalClassRule/Success/ClassWithProtectedMethod.php',
			'final-class-with-private-method'                                                              => __DIR__ . '/../../../fixtures/Methods/PrivateInFinalClassRule/Success/FinalClassWithPrivateMethod.php',
			'final-class-with-protected-method-extending-class-extending-class-with-same-protected-method' => __DIR__ . '/../../../fixtures/Methods/PrivateInFinalClassRule/Success/FinalClassWithProtectedMethodExtendingClassExtendingClassWithSameProtectedMethod.php',
			'final-class-with-protected-method-extending-class-with-same-protected-method'                 => __DIR__ . '/../../../fixtures/Methods/PrivateInFinalClassRule/Success/FinalClassWithProtectedMethodExtendingClassWithSameProtectedMethod.php',
			'final-class-with-public-method'                                                               => __DIR__ . '/../../../fixtures/Methods/PrivateInFinalClassRule/Success/FinalClassWithPublicMethod.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'final-class-with-protected-method' => [
				__DIR__ . '/../../../fixtures/Methods/PrivateInFinalClassRule/Failure/FinalClassWithProtectedMethod.php',
				[
					\sprintf(
						'Method %s::method() is protected, but since the containing class is final, it can be private.',
						Test\Fixture\Methods\PrivateInFinalClassRule\Failure\FinalClassWithProtectedMethod::class
					),
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


	protected function getRule(): Rules\Rule {
		return new PrivateInFinalClassRule();
	}
}
