<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Analyser\Error;
use PHPStan\DependencyInjection\MissingServiceException;
use PHPStan\File\CouldNotReadFileException;
use PHPStan\File\FileReader;
use PHPStan\Fixable\Patcher;
use PHPStan\Rules;

final class NoParamTypeRemovalRuleTest extends AbstractTestCase {
	use \StaticRule;

	public function testEveryRemovedParamTypeIsReported(): void {
		$path = __DIR__ . '/../../../fixtures/Methods/NoParamTypeRemovalRule/Failure/RemovedEveryParamType.php';

		$this->analyse(
			[
				$path,
			],
			[
				[
					NoParamTypeRemovalRule::ERROR_MESSAGE,
					10,
				],
				[
					NoParamTypeRemovalRule::ERROR_MESSAGE,
					10,
				],
			]
		);
	}


	/**
	 * @throws MissingServiceException
	 * @throws CouldNotReadFileException
	 */
	public function testEveryRemovedParamTypeIsFixedInOneRound(): void {
		$path = __DIR__ . '/../../../fixtures/Methods/NoParamTypeRemovalRule/Failure/RemovedEveryParamType.php';
		$expected = __DIR__ . '/../../../fixtures/Methods/NoParamTypeRemovalRule/Fixed/RemovedEveryParamType.php';
		$diffGroups = \array_map( function( Error $error ): array {
			return $error->getFixedErrorDiffs();
		}, $this->gatherAnalyserErrors( [ $path ] ) );
		$file = $diffGroups[0][0]->file;

		$result = self::getContainer()->getByType( Patcher::class )->apply( [ $file => FileReader::read( $file ) ], $diffGroups );

		self::assertSame( 0, $result['skippedCount'], 'No fix may wait for a later round.' );
		self::assertStringEqualsFile( $expected, $result['contents'][ $file ], 'One round restores every param type.' );
	}


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

		foreach ( self::singleErrorFailures() as $description => [$name, $line] ) {
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
		$names = \array_map( function( array $failure ): string {
			return $failure[0];
		}, self::singleErrorFailures() );
		$names['removed-every-param-type'] = 'RemovedEveryParamType';

		yield from self::fixCases( 'Methods/NoParamTypeRemovalRule', $names );
	}


	/**
	 * Failure fixtures reporting one error, as name and error line.
	 *
	 * @return array<string, array{string, int}>
	 */
	private static function singleErrorFailures(): array {
		return [
			'removed-class-type'                 => [ 'RemovedClassType', 10 ],
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
	}


	protected function getRule(): Rules\Rule {
		return self::staticRule( new NoParamTypeRemovalRule() );
	}
}
