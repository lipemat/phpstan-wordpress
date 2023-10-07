<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules;

use PHPStan\Testing\RuleTestCase;

abstract class AbstractTestCase extends RuleTestCase {
	/**
	 * @dataProvider provideCasesWhereAnalysisShouldSucceed
	 */
	final public function testAnalysisSucceeds( string $path ): void {
		self::assertFileExists( $path );

		$this->analyse(
			[
				$path,
			],
			[]
        );
	}


	/**
	 * @dataProvider provideCasesWhereAnalysisShouldFail
	 */
	final public function testAnalysisFails( string $path, array $error ): void {
		self::assertFileExists( $path );

		$this->analyse(
			[
				$path,
			],
			[
				$error,
			]
        );
	}


	abstract public static function provideCasesWhereAnalysisShouldSucceed(): iterable;


	abstract public static function provideCasesWhereAnalysisShouldFail(): iterable;
}
