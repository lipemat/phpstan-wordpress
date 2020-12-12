## PHPStan for WordPress

<p>
<a href="https://github.com/lipemat/phpstan-wordpress/releases">
<img src="https://img.shields.io/packagist/v/lipemat/phpstan-wordpress.svg?label=version" />
</a>
    <img src="https://img.shields.io/packagist/php-v/lipemat/phpstan-wordpress.svg?color=brown" />
    <img alt="Packagist" src="https://img.shields.io/packagist/l/lipemat/wp-phpcs.svg">
</p>

### Included Stubs
* The semi-official <a href="https://github.com/szepeviktor/phpstan-wordpress">phpstan-wordpress</a> stubs.
* Some custom stubs for WP VIP and others (in progress)

### Optional Stubs

* <a href="https://github.com/php-stubs/wp-cli-stubs">WP-CLI stubs</a>.
* <a href="https://github.com/php-stubs/woocommerce-stubs">WooCommerce Stubs</a>.

These may be selectively added to your `phstan.neon` or `phpstan.neon.dist` like so:

```yml
bootstrapFiles:
  - %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-stubs.php
scanFiles:
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-commands-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-i18n-stubs.php
```

### Usage

Install via composer

```bash
composer require lipemat/phpstan-wordpress
```