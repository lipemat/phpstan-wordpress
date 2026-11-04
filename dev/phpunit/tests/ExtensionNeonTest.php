<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan;

use Lipe\Lib\Phpstan\Services\TypeNodeResolver;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\Rules\LazyRegistry;
use PHPStan\Testing\PHPStanTestCase;

/**
 * `extension.neon` is always loaded, so it must register the utility types
 * and never a rule; rules stay opt-in through `rules.neon`.
 *
 * @author Mat Lipe
 * @since  November 2026
 *
 */
final class ExtensionNeonTest extends PHPStanTestCase {
	public static function getAdditionalConfigFiles(): array {
		return [
			\dirname( __DIR__, 3 ) . '/extension.neon',
		];
	}


	public function test_utility_types_registered(): void {
		$expected = [
			TypeNodeResolver\AtLeast::class,
			TypeNodeResolver\Exclude::class,
			TypeNodeResolver\Partial::class,
			TypeNodeResolver\Pick::class,
			TypeNodeResolver\Required::class,
			TypeNodeResolver\Sarcastic::class,
			TypeNodeResolver\Union::class,
		];

		$actual = self::package_classes( TypeNodeResolverExtension::EXTENSION_TAG );

		$this->assertSame( $expected, $actual, 'All 7 utility types must register from extension.neon alone.' );
	}


	public function test_no_rules_registered(): void {
		$actual = self::package_classes( LazyRegistry::RULE_TAG );

		$this->assertSame( [], $actual, 'extension.neon must not register rules; only rules.neon may scan src/Rules.' );
	}


	/**
	 * Sorted class names of this package's services carrying the tag.
	 *
	 * @return list<class-string>
	 */
	private static function package_classes( string $tag ): array {
		$classes = \array_map( function( object $service ): string {
			return $service::class;
		}, self::getContainer()->getServicesByTag( $tag ) );
		$classes = \array_values( \array_filter( $classes, function( string $class_name ): bool {
			return \str_starts_with( $class_name, __NAMESPACE__ . '\\' );
		} ) );
		\sort( $classes );
		return $classes;
	}
}
