# Rules

Every rule touches four places; a change is done when all four agree.

1. **Class** in `src/Rules/<NodeCategory>/<Name>Rule.php` implementing `PHPStan\Rules\Rule` with `@implements Rules\Rule<NodeType>`. Build errors with `RuleErrorBuilder`, an `identifier( 'lipemat.<camelName>' )`, and usually an `addTip()`. Example: `src/Rules/Statements/NoSwitchRule.php`.
2. **Registration** in `rules.neon`:
   - Always-on rules get the `phpstan.rules.rule` tag directly.
   - Rules gated by a `lipemat` parameter are listed untagged and tagged via `conditionalTags` (see `FinalRule` -> `%lipemat.nonDistributed%`).
   - Constructor arguments come from `%lipemat.*%`. A new parameter needs an entry in `parametersSchema`, a default under `parameters.lipemat`, and `expandRelativePaths` if it is a path.
   - `PrivateInFinalClassRule` exists but is intentionally unregistered (disabled by default).
   - `src/Rules/Internal/` rules are `@internal` easter eggs for the author's own projects (`themePath`, `Factory::factorize()`); keep them out of `Readme.md`.
3. **Test** in `dev/phpunit/tests/Rules/<NodeCategory>/<Name>RuleTest.php`:
   - Extend `Lipe\Lib\Phpstan\Rules\AbstractTestCase`; implement `provideCasesWhereAnalysisShouldSucceed()` and `provideCasesWhereAnalysisShouldFail()` as generators of named cases.
   - Each failure case is `[ path, [ message, line ] ]`. The message includes the tip, joined as `"...\n    💡 <tip>"`.
   - A fixable rule also overrides `provideCasesWithFixes()` with `[ failure path, fixed path ]` cases, asserted by `RuleTestCase::fix()` in rounds until nothing is fixable. The default yields each failure fixture as an unchanged-by-fix case, so rules without fixes need no override; an override that wants that assertion for its remaining fixtures adds `yield from parent::provideCasesWithFixes();`. Fix callbacks share one rule instance, so they must capture no state.
   - `use \StaticRule;` and return `self::staticRule( new XRule() )` from `getRule()` so one rule instance sees every fixture, surfacing state leaks.
   - Variants with different parameters are separate test classes (`FinalRuleWithAbstractClassesAllowedTest`).
4. **Fixtures** in `dev/phpunit/fixtures/<NodeCategory>/<TestVariant>/{Success,Failure,Fixed}/`, one scenario per file. Fixture classes use namespace `Lipe\Lib\Phpstan\Rules\Test\Fixture\...` (autoload-dev). `Fixed/` holds the post-fix copy of a `Failure/` fixture under the same file name, and only exists for fixable rules. A `Fixed/` file is read as expected content, never analysed, so it keeps the namespace of the `Failure/` fixture it mirrors; `autoload-dev.exclude-from-classmap` keeps that duplicate out of the optimized classmap.

User-facing rules are also listed in `Readme.md` under "Optional Included Rules"; rules affected by `nonDistributed: false` are listed again under "Distributed plugins or themes".
