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


	#[DataProvider( 'provideCasesWithFixes' )]
	final public function testFixesAreApplied( string $path, string $expected ): void {
		self::assertFileExists( $path );
		self::assertFileExists( $expected );

		$this->fix( $path, $expected );
	}


	abstract public static function provideCasesWhereAnalysisShouldSucceed(): iterable;


	/**
	 * @return iterable<string, array{string, array{string, int}}>
	 */
	abstract public static function provideCasesWhereAnalysisShouldFail(): iterable;


	/**
	 * Rules without fixes assert their failure fixtures are unchanged; an empty provider errors in PHPUnit.
	 *
	 * @return iterable<string, array{string, string}>
	 */
	public static function provideCasesWithFixes(): iterable {
		foreach ( static::provideCasesWhereAnalysisShouldFail() as $description => [$path] ) {
			yield $description => [
				$path,
				$path,
			];
		}
	}
}
