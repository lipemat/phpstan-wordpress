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
final class TemplatePartFunctionExistsRuleTest extends RuleTestCase {
	protected function getRule(): TemplatePartFunctionExistsRule {
		return new TemplatePartFunctionExistsRule( 'fixtures/Internal/TemplatePartFunctionExistsRule',
			new FileHelper( \dirname( __DIR__, 3 ) ),
		);
	}


	public function testRule(): void {
		$this->analyse( [
			__DIR__ . '/../../../fixtures/Internal/TemplatePartFunctionExistsRule/Failure/functions.php',
		],
			[
				[
					'Template part file "email/daily-report.php" does not exist.',
					6,
				],
			]
		);
	}


	#[DataProvider( 'providePaths' )]
	public function testGetTemplatePath( string $raw_path, string $expected_path ): void {
		$rule = $this->getRule();
		$translated_path = $rule->getTemplatePath( $raw_path );
		$this->assertSame( $expected_path, $translated_path );
	}


	public static function providePaths(): array {
		$root = ( new FileHelper( __DIR__ ) )->normalizePath( \getcwd(), '/' ) . '/fixtures/Internal/TemplatePartFunctionExistsRule/';

		return [
			'unix'     => [
				'raw_path'      => '/path/to/template',
				'expected_path' => $root . 'template-parts/path/to/template.php',
			],
			'special'  => [
				'raw_path'      => '../woocommerce/email/daily-report',
				'expected_path' => $root . 'woocommerce/email/daily-report.php',
			],
			'standard' => [
				'raw_path'      => 'TemplatePart',
				'expected_path' => $root . 'template-parts/TemplatePart.php',
			],
		];
	}
}
