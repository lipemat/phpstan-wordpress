# Stubs

- `stubs/wp.php` (constants and extra WordPress symbols) is always scanned via `extension.neon`. Constants whose value varies per site also belong in `dynamicConstantNames` there.
- `stubs/vip.php` is hand-written and opt-in.
- `stubs/cmb2/` and `stubs/genesis/` are generated; never edit them by hand.

## Regenerating CMB2 / Genesis / WooCommerce Subscriptions

1. Bump the source package in `dev/source/composer.json` (a separate composer project holding `php-stubs/generator`), then run `composer update` inside `dev/source`.
2. Set `THEME_VERSION` / `PLUGIN_VERSION` in the matching `dev/stub-generators/<name>.sh`.
3. Run the script from the repo root with Git Bash: `bash dev/stub-generators/genesis.sh`. PhpStorm run configurations `Generate CMB2`, `Generate Genesis`, `Generate WooCommerce Subscriptions` do the same.
4. The script writes a **new** `stubs/<name>/<name>-<version>.php`. Keep older files: consumers reference them by exact path in `scanFiles`.
5. Update the example version paths in `Readme.md` if the recommended version changed.

The Genesis and WooCommerce Subscriptions generators delete dev-only folders from `dev/source/vendor/...` before generating, so rerunning requires a fresh `composer install` in `dev/source`.
