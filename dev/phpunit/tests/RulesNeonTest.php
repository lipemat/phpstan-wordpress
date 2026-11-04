<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan;

use Lipe\Lib\Phpstan\Rules\Classes;
use Lipe\Lib\Phpstan\Rules\Expressions;
use Lipe\Lib\Phpstan\Rules\Files;
use Lipe\Lib\Phpstan\Rules\Internal;
use Lipe\Lib\Phpstan\Rules\Methods;
use Lipe\Lib\Phpstan\Rules\Statements;
use PHPStan\Rules\LazyRegistry;
use PHPStan\Testing\PHPStanTestCase;

/**
 * Including `rules.neon` registers every attributed rule in `src/Rules`
 * with the default `lipemat` parameters.
 *
 * @author Mat Lipe
 * @since  November 2026
 *
 */
final class RulesNeonTest extends PHPStanTestCase {
	public static function getAdditionalConfigFiles(): array {
		return [
			\dirname( __DIR__, 3 ) . '/extension.neon',
			\dirname( __DIR__, 3 ) . '/rules.neon',
		];
	}


	public function test_default_rules_registered(): void {
		$expected = [
			Classes\FinalRule::class,
			Expressions\NoCompactRule::class,
			Expressions\NoExtractRule::class,
			Files\DeclareStrictTypesRule::class,
			Internal\FactorizeConstructorArgsRule::class,
			Internal\TemplatePartExistsRule::class,
			Internal\TemplatePartFunctionExistsRule::class,
			Methods\FinalInAbstractClassRule::class,
			Methods\NoConstructorParameterWithDefaultValueRule::class,
			Methods\NoParamTypeRemovalRule::class,
			Methods\NoUnknownMethodCallerRule::class,
			Methods\ReturnNullOverFalseRule::class,
			Statements\NoArrayAccessOnObjectRule::class,
			Statements\NoIssetOnObjectRule::class,
			Statements\NoSwitchRule::class,
			Statements\NoUnknownPropertyRule::class,
		];

		$actual = \array_map( function( object $rule ): string {
			return $rule::class;
		}, self::getContainer()->getServicesByTag( LazyRegistry::RULE_TAG ) );
		$actual = \array_values( \array_filter( $actual, function( string $class_name ): bool {
			return \str_starts_with( $class_name, __NAMESPACE__ . '\\' );
		} ) );
		\sort( $actual );

		$this->assertSame( $expected, $actual, 'Defaults register every rule except the opt-in NoExtendsRule and the disabled PrivateInFinalClassRule.' );
	}
}
