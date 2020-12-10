## PHPStan for WordPress

<p>
<a href="https://github.com/lipemat/phpstan-wordpress/releases">
<img src="https://img.shields.io/packagist/v/lipemat/phpstan-wordpress.svg?label=version" />
</a>
    <img src="https://img.shields.io/packagist/php-v/lipemat/phpstan-wordpress.svg?color=brown" />
    <img alt="Packagist" src="https://img.shields.io/packagist/l/lipemat/wp-phpcs.svg">
</p>

#### Includes
* <a href="https://github.com/php-stubs/wp-cli-stubs">WP-CLI stubs</a>.
* The semi-official <a href="https://github.com/szepeviktor/phpstan-wordpress">phpstan-wordpress</a> stubs.
* Some custom stubs for WP VIP and others (in progress)

### Usage

Install via composer

```bash
composer require lipemat/phpstan-wordpress
```

Include the `extension.neon` in your `phpstan.neon` or `phpstan.neon.dist`.

```yml
includes:
  - vendor/lipemat/phpstan-wordpress/extension.neon
```
