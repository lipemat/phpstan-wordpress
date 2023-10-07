<?php

namespace Lipe\Lib\Phpstan;

use Composer\Script\Event;
use PHPStan\ExtensionInstaller\Plugin;

/**
 * The plugin installer will not add the root package to the
 * available plugins.
 *
 * When this package is installed as a dependency the plugin
 * installer sets everything up automatically.
 * When this package is the root package e.g. (installed as a standalone)
 * this class adds itself as a local package and calls the original
 * `process` method which generates the configuration.
 *
 * Without this class, the package can not function as a standalone without
 * `including` the `extension.neon` in every `phpstan.neon`.
 *
 * @author Mat Lipe
 * @since  December 2020
 *
 */
class AddRootToExtensions {
	public static function updatePlugins( Event $event ): void {
		$composer = $event->getComposer();
		$package = $composer->getPackage();
		$extra = $package->getExtra();
		$extra['phpstan']['includes'] = [ '../../../extension.neon' ];
		$package->setExtra( $extra );
		$io = $event->getIO();

		try {
			$composer->getRepositoryManager()->getLocalRepository()->addPackage( $package );
		} catch ( \LogicException $exception ) {
			$io->write( '<error>To use `lipemat/phpstan` as standalone, you must either install fresh without a lock file or run `composer update`.</error>' );
			return;
		}

		$io->write( '<comment>Adding lipemat/phpstan-wordpress package as a phpstan extension.</comment>' );

		( new Plugin() )->process( $event );
	}
}
