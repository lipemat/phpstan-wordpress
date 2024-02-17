# PHPStan for WordPress

<p>
<a href="https://github.com/lipemat/phpstan-wordpress/releases">
<img alt="package version" src="https://img.shields.io/packagist/v/lipemat/phpstan-wordpress.svg?label=version" />
</a>
    <img alt="php version" src="https://img.shields.io/packagist/php-v/lipemat/phpstan-wordpress.svg?color=brown" />
    <img alt="Packagist" src="https://img.shields.io/packagist/l/lipemat/wp-phpcs.svg">
</p>

## Usage

Install via composer

```bash
composer require lipemat/phpstan-wordpress
```

## Included Stubs
1. The semi-official <a href="https://github.com/szepeviktor/phpstan-wordpress">phpstan-wordpress</a> stubs.
2. Custom stubs
    1. `lipe.php` stubs specific for `Lipe\Project` projects.
    2. `wp.php` some additional stubs for WordPress

## Optional Stubs

1. <a href="https://github.com/php-stubs/wp-cli-stubs">WP-CLI stubs</a>.
2. <a href="https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/wp-cli/php-cli-tools-0.11.11.php">WP-CLI Tools Stubs</a>.
3. <a href="https://github.com/php-stubs/woocommerce-stubs">WooCommerce Stubs</a>.
4. [CMB2 stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/cmb2/)
5. [Genesis stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/genesis/)
6. [WooCommerce Subscription stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/woocommerce-subscriptions/)
7. [VIP stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/vip.php) some stubs for WP VIP environments.

These may be selectively added to your `phpstan.neon` or `phpstan.neon.dist` like so:

### When using library as a global install

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
stubFiles:
  - %rootDir%/../../../stubs/wp-cli/wp-cli.stub
```

### When using library as composer dependency

*@notice: Woocommerce does not work as a `scanFile` and must be a `bootstrapFiles`.*

```yml
bootstrapFiles:
  - %rootDir%/../../php-stubs/woocommerce-stubs/woocommerce-stubs.php
scanFiles:
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/cmb2/cmb2-3.10.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/genesis/genesis-3.4.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/woocommerce-subscriptions/woocommerce-subscriptions-4.7.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/wp-cli/php-cli-tools-0.11.11.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/vip.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-commands-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-i18n-stubs.php
stubFiles:
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/wp-cli/wp-cli.stub
```

Alternatively, you may replace `%rootDir%/../../` with the relative path to your `vendor` directory.

Example `wp-content/plugins/core/vendor/lipemat/phpstan-wordpress/stubs/cmb2/cmb2-3.10.php`

## Utility Types

### `Union<T, U, ...X>`

Combine two or more array shapes as if you were using `array_merge` with the second array overwriting the first.

```php
/**
 * @phpstan-var Union<array{a: string}, array{b: string}> $array
 *   // results: array{a: string, b: string}
 */
```

### `AtLeast<T, U>`

Mark a set of array shape keys as required while leaving the rest as is.

```php
/**
 * @phpstan-var AtLeast<array{a?: string, b?: string}, 'a'> $array
 *   // results: array{a: string, b?: string}
 */
```

## Optional Included Rules

As we move toward a world where we use composition over inheritance, we need to be more strict about how we write our code.
These optional rules don not get us all the way there, but they are a step in the right direction while still being viable for a WordPress project.

Enable in your `phpstan.neon` or `phpstan.neon.dist` like so:

```yml
includes:
# If you are using this library as a global install
  - %rootDir%/../../../rules.neon
# If you are using this library as a composer dependency
  - %rootDir%/../../lipemat/phpstan-wordpress/rules.neon
  
```

1. Prevent using the `compact` function.
2. Require all classes to be either abstract or final.
3. Require a `declare(strict_types=1)` statement in every non-empty file.
4. Prevent using default values in class constructors.
5. Prevent declaring a method `protected` in a final class in favor of `private`.
6. Prevent using the `switch` statement in favor of `match`.
7. Require any concrete methods in abstract classes to be `private` or `final`.

### Distributed plugins or themes
Some rules assume you are working on a private project which will not be distributed to the community. 
If your project will be distributed, you may add the `nonDistributed` parameter to the `lipemat` parameter.

```yml
parameters:
    lipemat:
      nonDistributed: false
```
The `nonDistributed` set to `false` parameter will disable the following rules:
1. Require all classes to be either abstract or final.
2. Require a `declare(strict_types=1)` statement in every non-empty file.
3. Require any concrete methods in abstract classes to be `private` or `final`.

### Prevent any inheritance
Adding the `noExtends` parameter to the `lipemat` parameter will prevent having or extending any unlisted abstract classes. 

```yml
parameters:
    lipemat:
      allowedToBeExtended: 
        - Lipe\Project\SomeAbstractClass
        - Lipe\Project\SomeOtherAbstractClass
      noExtends: true
```

You may omit the `allowedToBeExtended` parameter to prevent extending any abstract classes.
