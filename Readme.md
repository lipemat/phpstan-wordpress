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
3. [CMB2 stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/cmb2/)
4. [Genesis stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/genesis/)
5. [WooCommerce Subscription stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/woocommerce-subscriptions/)   
6. [VIP stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/vip.php) some stubs for WP VIP environments. 

These may be selectively added to your `phpstan.neon` or `phpstan.neon.dist` like so:

#### When using library as a global install

*@notice: Woocommerce does not work as a `scanFile` and must be a `bootstrapFiles`.*

```yml
bootstrapFiles:
    - %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-stubs.php
scanFiles:
  - %rootDir%/../../../stubs/cmb2/cmb2-3.10.php
  - %rootDir%/../../../stubs/genesis/genesis-3.4.php
  - %rootDir%/../../../stubs/woocommerce-subscriptions/woocommerce-subscriptions-4.7.php 
  - %rootDir%/../../../stubs/vip.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-commands-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-i18n-stubs.php
```

#### When using library as composer dependency

*@notice: Woocommerce does not work as a `scanFile` and must be a `bootstrapFiles`.*

```yml
bootstrapFiles:
  - %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-stubs.php
scanFiles:
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/cmb2/cmb2-3.10.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/genesis/genesis-3.4.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/woocommerce-subscriptions/woocommerce-subscriptions-4.7.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/vip.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-commands-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-i18n-stubs.php
```

Alternatively, you may replace `%rootDir%/../../` with the relative path to your `vendor` directory.

Example `wp-content/plugins/core/vendor/lipemat/phpstan-wordpress/stubs/cmb2/cmb2-3.10.php`

### Usage

Install via composer

```bash
composer require lipemat/phpstan-wordpress
```
