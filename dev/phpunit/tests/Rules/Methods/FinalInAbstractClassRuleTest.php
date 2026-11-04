<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use Lipe\Lib\Phpstan\Rules\Test;
use PHPStan\Rules;

final class FinalInAbstractClassRuleTest extends AbstractTestCase {
	use \StaticRule;

	private static $message = "Method %s::method() is not final, but since the containing class is abstract, it should be.\n    💡 If overriding is necessary, an abstract method should be used instead.";


	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'abstract-class-with-abstract-method'        => __DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Success/AbstractClassWithAbstractMethod.php',
			'abstract-class-with-final-protected-method' => __DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Success/AbstractClassWithFinalProtectedMethod.php',
			'abstract-class-with-final-public-method'    => __DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Success/AbstractClassWithFinalPublicMethod.php',
			'abstract-class-with-non-final-constructor'  => __DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Success/AbstractClassWithNonFinalConstructor.php',
			'abstract-class-with-private-method'         => __DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Success/AbstractClassWithPrivateMethod.php',
			'interface-with-public-method'               => __DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Success/InterfaceWithPublicMethod.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$paths = [
			'abstract-class-with-protected-method' => [
				__DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Failure/AbstractClassWithProtectedMethod.php',
				[
					\sprintf( self::$message,
						Test\Fixture\Methods\FinalInAbstractClassRule\Failure\AbstractClassWithProtectedMethod::class
					),
					8,
				],
			],
			'abstract-class-with-public-method'    => [
				__DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Failure/AbstractClassWithPublicMethod.php',
				[
					\sprintf(
						self::$message,
						Test\Fixture\Methods\FinalInAbstractClassRule\Failure\AbstractClassWithPublicMethod::class
					),
					8,
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
		$failure = __DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Failure/';
		$fixed = __DIR__ . '/../../../fixtures/Methods/FinalInAbstractClassRule/Fixed/';

		$names = [
			'abstract-class-with-protected-method' => 'AbstractClassWithProtectedMethod',
			'abstract-class-with-public-method'    => 'AbstractClassWithPublicMethod',
		];

		foreach ( $names as $description => $name ) {
			yield $description => [
				$failure . $name . '.php',
				$fixed . $name . '.php',
			];
		}
	}


	protected function getRule(): Rules\Rule {
		return self::staticRule( new FinalInAbstractClassRule() );
	}
}
