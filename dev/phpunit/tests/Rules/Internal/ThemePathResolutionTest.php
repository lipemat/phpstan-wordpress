<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Internal;

use PHPStan\File\FileHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * A relative `lipemat.themePath` must resolve against the directory of the
 * config file which declares it, never the current working directory.
 *
 * @author Mat Lipe
 * @since  October 2026
 *
 */
final class ThemePathResolutionTest extends RuleTestCase {
	public static function getAdditionalConfigFiles(): array {
		return [
			self::fixtureDirectory() . '/phpstan.neon',
		];
	}


	protected function getRule(): TemplatePartExistsRule {
		return new TemplatePartExistsRule( self::configuredThemePath(), new FileHelper( \sys_get_temp_dir() ) );
	}


	public function testRelativePathResolvesAgainstConfigDirectory(): void {
		$this->assertSamePaths( self::fixtureDirectory() . '/child-theme', (string) self::configuredThemePath() );
	}


	public function testExistingPartFoundFromForeignWorkingDirectory(): void {
		$this->analyse( [
			self::fixtureDirectory() . '/Theme/TemplatePart.php',
		], [] );
	}


	public function testAbsolutePathIsUnchanged(): void {
		$rule = new TemplatePartExistsRule( self::fixtureDirectory() . '/child-theme', new FileHelper( \sys_get_temp_dir() ) );
		$this->assertFileExists( $rule->getTemplatePath( 'header/nav' ) );
	}


	private static function configuredThemePath(): ?string {
		$lipemat = self::getContainer()->getParameter( 'lipemat' );
		\assert( \is_array( $lipemat ) );
		return $lipemat['themePath'];
	}


	private static function fixtureDirectory(): string {
		return ( new FileHelper( __DIR__ ) )->normalizePath( \dirname( __DIR__, 3 ) . '/fixtures/Internal/ThemePath', '/' );
	}
}
