# AGENTS.md

PHPStan extension (`lipemat/phpstan-wordpress`) for WordPress projects. Distributed on Packagist; consumers install it globally or as a composer dependency, so every path in `Readme.md` must work from both `%rootDir%` layouts.

## Layout

- `extension.neon`: always loaded (via `extra.phpstan.includes`). Registers the utility types in `src/Services/TypeNodeResolver/` and ships `stubs/wp.php`.
- `rules.neon`: opt-in rules in `src/Rules/<NodeCategory>/`, plus the `lipemat` parameter schema (`nonDistributed`, `noExtends`, `allowedToBeExtended`, `themePath`).
- `stubs/`: optional `scanFiles` for consumers (CMB2, Genesis, VIP). One file per upstream version; old versions stay because consumers pin them by path.
- `php-version.php`: analyse against the running PHP version instead of `require.php`.
- `src/AddRootToExtensions.php`: composer hook so the package works when it is the root package (global install). Excluded from analysis.
- `dev/`: tests, generators, hooks. Export-ignored by `.gitattributes`, so nothing under `dev/` may be needed at runtime.

## Commands

Run from the repo root unless noted:

- Tests: `cd dev/phpunit; phpunit` (config is `dev/phpunit/phpunit.xml.dist`; stops on first defect, notice, or deprecation).
- Static analysis: `phpstan analyse --no-progress --memory-limit=2G` (level 10, analyses `src` with this repo's own `rules.neon`).
- Coding standard: `phpcs` (WordPress-Extra on `src` only).
- `dev/git-hooks/pre-commit` runs all three; install with `composer git-hooks`.

## Conventions

- Namespace `Lipe\Lib\Phpstan\` maps to `src/`; tests share the source namespace (e.g. `Lipe\Lib\Phpstan\Rules\Statements\NoSwitchRuleTest`).
- Production classes are not `final`: this is a distributed package and phpcs `Universal.Classes.DisallowFinalClass` errors on it. Test classes may be `final`.
- Rule error identifiers use the `lipemat.` prefix (`lipemat.noSwitch`).
- Composer dependency versions are pinned tightly (`~`, exact) so upstream rule changes never surprise consumers; bump deliberately.
- `VERSION` holds the release number; a release is a `Bump to x.y.z` commit plus a tag, which triggers `.github/workflows/create-release.yml`.

## Task guides

- Adding or changing a rule in `rules.neon`: read [`.github/agents-sections/rules.md`](.github/agents-sections/rules.md).
- Adding or changing a utility type (`\Pick`, `\Union`, ...): read [`.github/agents-sections/utility-types.md`](.github/agents-sections/utility-types.md).
- Regenerating or adding third-party stubs in `stubs/`: read [`.github/agents-sections/stubs.md`](.github/agents-sections/stubs.md).

## Agent skills

### Issue tracker

Issues and tickets live in this repo's GitHub Issues, with status mirrored to GitHub project 16 (`lipemat`). See `.github/agents-sections/issue-tracker.md`.
