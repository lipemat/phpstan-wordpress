<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use Lipe\Lib\Phpstan\Rules\AbstractTestCase;
use PHPStan\Rules\Rule;

/**
 * @author Mat Lipe
 * @since  July 2024
 *
 */
class NoUnknownPropertyRuleTest extends AbstractTestCase {
	public static function provideCasesWhereAnalysisShouldSucceed(): iterable {
		$paths = [
			'skip-dynamic-name'  => __DIR__ . '/../../../fixtures/Statements/NoUnknownPropertyRule/Success/SkipDynamicNameWithKnownType.php',
			'skip-known-fetcher' => __DIR__ . '/../../../fixtures/Statements/NoUnknownPropertyRule/Success/SkipKnownFetcherType.php',
		];

		foreach ( $paths as $description => $path ) {
			yield $description => [
				$path,
			];
		}
	}


	public static function provideCasesWhereAnalysisShouldFail(): iterable {
		$message = 'Mixed property fetch in "$unknownType->..." can skip important errors. Make sure the type is known.
    💡 Try checking `instanceof` first.';
		$paths = [
			'dynamic-name'             => [ __DIR__ . '/../../../fixtures/Statements/NoUnknownPropertyRule/Failure/DynamicName.php', [ $message, 11 ] ],
			'unknown-property-fetcher' => [ __DIR__ . '/../../../fixtures/Statements/NoUnknownPropertyRule/Failure/UnknownPropertyFetcher.php', [ $message, 11 ] ],
		];

		foreach ( $paths as $description => [$path, $error] ) {
			yield $description => [
				$path,
				$error,
			];
		}
	}


	protected function getRule(): Rule {
		return new NoUnknownPropertyRule();
	}

}
