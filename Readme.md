## PHPStan for WordPress

<p>
<a href="https://github.com/lipemat/phpstan-wordpress/releases">
<img src="https://img.shields.io/packagist/v/lipemat/phpstan-wordpress.svg?label=version" />
</a>
    <img src="https://img.shields.io/packagist/php-v/lipemat/phpstan-wordpress.svg?color=brown" />
    <img alt="Packagist" src="https://img.shields.io/packagist/l/lipemat/wp-phpcs.svg">
</p>

### Included Stubs
1. The semi-official <a href="https://github.com/szepeviktor/phpstan-wordpress">phpstan-wordpress</a> stubs.
2. Custom stubs
    1. `lipe.php` stubs specific for `Lipe\Project` projects.
    2. `wp.php` some additional stubs for WordPress

### Optional Stubs

1. <a href="https://github.com/php-stubs/wp-cli-stubs">WP-CLI stubs</a>.
2. <a href="https://github.com/php-stubs/woocommerce-stubs">WooCommerce Stubs</a>.
3. [CMB2 stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/cmb2-2.7.0.php)
3. [Genesis stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/genesis/genesis-3.3.php)
4. [VIP stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/vip.php) some stubs for WP VIP environments. 

These may be selectively added to your `phstan.neon` or `phpstan.neon.dist` like so:

```yml
scanFiles:
  - %rootDir%/../../../stubs/cmb2-2.7.0.php
  - %rootDir%/../../../stubs/genesis/genesis-3.3.php 
  - %rootDir%/../../../stubs/vip.php
  - %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-commands-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-i18n-stubs.php
```

### Usage

Install via composer

```bash
composer require lipemat/phpstan-wordpress
```