<?php
/**
 * Analyse against the PHP version running PHPStan instead of
 * the `require.php` range from a composer.json.
 *
 * @see Readme.md
 */

declare( strict_types=1 );

return [
	'parameters' => [
		'phpVersion' => PHP_VERSION_ID,
	],
];
