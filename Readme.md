## PHPStan for WordPress

<p>
<a href="https://github.com/lipemat/phpstan-wordpress/releases">
<img src="https://img.shields.io/packagist/v/lipemat/phpstan-wordpress.svg?label=version" />
</a>
    <img src="https://img.shields.io/packagist/php-v/lipemat/phpstan-wordpress.svg?color=brown" />
    <img alt="Packagist" src="https://img.shields.io/packagist/l/lipemat/wp-phpcs.svg">
</p>

### Usage

Install via composer

```bash
composer require lipemat/phpstan-wordpress
```

### Included Stubs
1. The semi-official <a href="https://github.com/szepeviktor/phpstan-wordpress">phpstan-wordpress</a> stubs.
2. Custom stubs
    1. `lipe.php` stubs specific for `Lipe\Project` projects.
    2. `wp.php` some additional stubs for WordPress

### Optional Stubs

1. <a href="https://github.com/php-stubs/wp-cli-stubs">WP-CLI stubs</a>.
2. <a href="https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/wp-cli/php-cli-tools-0.11.11.php">WP-CLI Tools Stubs</a>.
3. <a href="https://github.com/php-stubs/woocommerce-stubs">WooCommerce Stubs</a>.
4. [CMB2 stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/cmb2/
5. [Genesis stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/genesis/)
6. [WooCommerce Subscription stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/woocommerce-subscriptions/)   
7. [VIP stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/vip.php) some stubs for WP VIP environments. 

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
  - %rootDir%/../../../stubs/wp-cli/php-cli-tools-0.11.11.php
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

## Included Custom Rules
1. Prevent using the `compact` function.
2. Prevent using the `eval` function.
3. Prevent suppressing of errors via the `@` operator.

### Optional Strict Rules

As we move toward a world were we use composition over inheritance, we need to be more strict about how we write our code. The strict rules by no means get us all the way there, but 
they are a step in the right direction and viable for a WordPress project.

The strict rules are not included by default, but may be enabled in your `phpstan.neon` or `phpstan.neon.dist` like so:

```yml
parameters:
  lipematStrict: true
```

1. Require all classes to be either abstract or final.
2. Require a `declare(strict_types=1)` statement in every non-empty file.
3. Prevent using default values in class constructors.
4. Prevent declaring a method `protected` in a final class in favor of `private`.

#### To take things even further
This rule will prevent having or extending any unlisted abstract classes. 

You may omit the `allowedToBeExtended` parameter to prevent extending any abstract classes.

```yml
parameters:
    lipematNoExtends:
        enabled: true
        allowedToBeExtended: 
          - AbstractClass1
          - AbstractClass2
```
