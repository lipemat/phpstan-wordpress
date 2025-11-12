<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules;

use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

abstract class AbstractTestCase extends RuleTestCase {
	#[DataProvider( 'provideCasesWhereAnalysisShouldSucceed' )]
	final public function testAnalysisSucceeds( string $path ): void {
		self::assertFileExists( $path );

		$this->analyse(
			[
				$path,
			],
			[]
		);
	}


	#[DataProvider( 'provideCasesWhereAnalysisShouldFail' )]
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
