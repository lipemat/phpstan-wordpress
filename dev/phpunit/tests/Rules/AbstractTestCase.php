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


	/**
	 * Pair each `Failure/` fixture of a variant with its expected content after fixing.
	 *
	 * @param string                    $variant  Fixtures directory of the variant, e.g. `Classes/FinalRule`.
	 * @param array<int|string, string> $names    Fixture names without `.php`, keyed by case description when it differs.
	 * @param string                    $expected `Failure` for fixtures the fix must leave unchanged.
	 *
	 * @return iterable<string, array{string, string}>
	 */
	protected static function fixCases( string $variant, array $names, string $expected = 'Fixed' ): iterable {
		$fixtures = \dirname( __DIR__, 2 ) . '/fixtures/' . $variant . '/';

		foreach ( $names as $description => $name ) {
			yield ( \is_string( $description ) ? $description : $name ) => [
				$fixtures . 'Failure/' . $name . '.php',
				$fixtures . $expected . '/' . $name . '.php',
			];
		}
	}
}
