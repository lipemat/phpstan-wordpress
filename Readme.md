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
   1. `wp.php` some additional stubs for WordPress

## Optional Stubs

1. <a href="https://github.com/php-stubs/wp-cli-stubs">WP-CLI stubs</a>.
2. ~~WP-CLI Tools Stubs.~~ Included in the [wp-cli-stubs](https://github.com/php-stubs/wp-cli-stubs/blob/master/wp-cli-tools-stubs.php) package since version 2.11.0.
3. [CMB2 stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/cmb2/)
4. [Genesis stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/genesis/)
5. [VIP stubs](https://github.com/lipemat/phpstan-wordpress/tree/master/stubs/vip.php) some stubs for WP VIP environments.

These may be selectively added to your `phpstan.neon` or `phpstan.neon.dist` like so:

### When using library as a global install


```yml
scanFiles:
  - %rootDir%/../../../stubs/cmb2/cmb2-3.10.php
  - %rootDir%/../../../stubs/genesis/genesis-3.4.php
  - %rootDir%/../../../stubs/vip.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-commands-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-i18n-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-tools-stubs.php
```

### When using library as composer dependency

```yml
scanFiles:
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/cmb2/cmb2-3.10.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/genesis/genesis-3.4.php
  - %rootDir%/../../lipemat/phpstan-wordpress/stubs/vip.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-commands-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-i18n-stubs.php
  - %rootDir%/../../php-stubs/wp-cli-stubs/wp-cli-tools-stubs.php
```

Alternatively, you may replace `%rootDir%/../../` with the relative path to your `vendor` directory.

Example `wp-content/plugins/core/vendor/lipemat/phpstan-wordpress/stubs/cmb2/cmb2-3.10.php`

## Utility Types


### `\AtLeast<T, U>`

Mark a set of array shape keys as required while making the rest optional.

```php
/**
 * @phpstan-var \AtLeast<array{a?: string, b?: string}, 'a'> $array
 *   // results: array{a: string, b?: string}
 */
```

### `\Exclude<T, K>`

Exclude the specified keys from an array shape.

```php
/**
 * @phpstan-var \Exclude<array{a: string, b: string}, 'a'> $array
 *   // results: array{b: string}
 */
```

### `\Partial<T>`

Mark either all or specified keys in an array shape as optional.

- `\Partial<T>`: Mark all keys as optional.
- `\Partial<T, K>`: Mark only the specified keys as optional.

```php
/**
 * @phpstan-var \Optional<array{a: string, b: string}> $array
 *   // results: array{a?: string, b?: string}
 * 
 * @phpstan-var \Optional<array{a: string, b: string}, 'b'> $array
 *   // results: array{a: string, b?: string}
 */
```

### `\Pick<T, K>`

Pick only the specified keys from an array shape.

```php
/**
 * @phpstan-var \Pick<array{a: string, b: string}, 'a'> $array
 *   // results: array{a: string}
 */
```

### `\Required<T>`

Mark either all or specified keys in an array shape as required.

- `\Required<T>`: Mark all keys as required.
- `\Required<T, K>`: Mark only the specified keys as required.

```php
/**
 * @phpstan-var \Required<array{a?: string, b?: string}> $array
 *   // results: array{a: string, b: string}
 *                                                            
 * @phpstan-var \Required<array{a?: string, b?: string}, 'b'> $array
 *   // results: array{a?: string, b: string}                                                  
 */
```

### `\Sarcastic<T>`

Mark a type as an unpredictable random value.

_This utility is extremely useful in everyday projects._

```php
/**
 * @phpstan-var \Sarcastic<string> $string
 *   // results: anyone's guess
 */
```

### `\Union<T, U, ...X>`

Combine two or more array shapes as if you were using `array_merge` with the second array overwriting the first.

```php
/**
 * @phpstan-var \Union<array{a: string}, array{b: string}> $array
 *   // results: array{a: string, b: string}
 */
```

## Optional Included Rules

As we move toward a world where we use composition over inheritance, we need to be more strict about how we write our code.
These optional rules do not get us all the way there, but they are a step in the right direction while still being viable for a WordPress project.

Enable in your `phpstan.neon` or `phpstan.neon.dist` like so:

```yml
includes:
# If you are using this library as a globally installed library.
  - %rootDir%/../../../rules.neon
# If you are using this library as a composer dependency.
  - %rootDir%/../../lipemat/phpstan-wordpress/rules.neon
  
```

1. Prevent using the `compact` function.
2. Prevent using the `extract` function.
3. Require all classes to be either abstract or final.
4. Require a `declare(strict_types=1)` statement in every non-empty file.
5. Prevent using default values in class constructors.
6. Prevent declaring a method `protected` in a final class in favor of `private`.
   1. Rule is now disabled by default but may be enabled manually.
7. Prevent using the `switch` statement in favor of `match`.
8. Require any concrete methods in abstract classes to be `private` or `final`.
9. Prevent child classes from skipping parent parameter types.
10. Prevent calls to methods on unknown classes.
11. Prefer returning null over false unless boolean is expected.
12. Prohibit using `ArrayAccess` to access class data.
13. Require `instance of` instead of `isset` for object verification.

### Distributed plugins or themes
Some rules assume you are working on a private project which will not be distributed to the community. 
If your project is distributed, you may add the `nonDistributed` parameter to the `lipemat` parameter.

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
