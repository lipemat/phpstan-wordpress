<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Internal;

use PHPStan\File\FileHelper;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @author Mat Lipe
 * @since  March 2026
 *
 */
final class TemplatePartExistsRuleTest extends RuleTestCase {
	protected function getRule(): TemplatePartExistsRule {
		return new TemplatePartExistsRule( new FileHelper( __DIR__ ) );
	}


	public function testRule(): void {
		// first argument: path to the example file that contains some errors that should be reported by MyRule
		// second argument: an array of expected errors,
		// each error consists of the asserted error message, and the asserted error file line
		$this->analyse( [
			__DIR__ . '/../../../fixtures/Internal/TemplatePartExistsRule/Failure/TemplatePart.php',
		],
			[
				[
					'Template part file "email/daily-report.php" does not exist.', // asserted error message
					9, // asserted error line
				],
			]
		);

		// the test fails, if the expected error does not occur,
		// or if there are other errors reported beside the expected one
	}


	#[DataProvider( 'providePaths' )]
	public function testTranslateTempPath( string $raw_path, string $expected_path ): void {
		$rule = $this->getRule();
		$translated_path = $rule->translateTempPath( $raw_path );
		$this->assertSame( $expected_path, $translated_path );
	}


	public static function providePaths(): array {
		return [
			'unix'     => [
				'raw_path'      => '/path/to/template.php',
				'expected_path' => '/path/to/template.php',
			],
			'phpstorm' => [
				'raw_path'      => 'C:\Users\mat\AppData\Local\Temp\PHPStantemp_folder753\wp-content/themes/core/template-parts/TemplatePart.php',
				'expected_path' => ( new FileHelper( __DIR__ ) )->normalizePath( \getcwd(), '/' ) . '/wp-content/themes/core/template-parts/TemplatePart.php',
			],
			'standard' => [
				'raw_path'      => 'E:\SVN\starting-point\wp-content/themes/core/template-parts/TemplatePart.php',
				'expected_path' => 'E:/SVN/starting-point/wp-content/themes/core/template-parts/TemplatePart.php',
			],
		];
	}
}
