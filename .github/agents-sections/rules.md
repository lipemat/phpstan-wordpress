# Rules

Every rule touches three places; a change is done when all three agree.

1. **Class** in `src/Rules/<NodeCategory>/<Name>Rule.php` implementing `PHPStan\Rules\Rule` with `@implements Rules\Rule<NodeType>`. Build errors with `RuleErrorBuilder`, an `identifier( 'lipemat.<camelName>' )`, and usually an `addTip()`. Example: `src/Rules/Statements/NoSwitchRule.php`. Registration rides on the class, from the `attributeServicesDirectories` scan of `src/Rules` which `rules.neon` declares:
   - Always-on rules carry `#[RegisteredRule( level: 0 )]`; `level: 0` means every level.
   - Rules gated by a `lipemat` parameter wrap that registration in `#[Conditional]` (see `FinalRule` -> `#[Conditional( new RegisteredRule( level: 0 ), if: '%lipemat.nonDistributed%' )]`).
   - Constructor arguments come from `%lipemat.*%` through `#[AutowiredParameter( ref: '%lipemat.themePath%' )]` on the parameter; parameters taking a PHPStan service are autowired by type and carry no attribute. A new parameter needs, in `rules.neon`, an entry in `parametersSchema`, a default under `parameters.lipemat`, and `expandRelativePaths` if it is a path.
   - `PrivateInFinalClassRule` exists but carries no attribute, which is what keeps it disabled.
   - Only the `@api` attributes may be used; any other PHPStan attribute is reported as `phpstanApi.attribute`.
   - `src/Rules/Internal/` rules are `@internal` easter eggs for the author's own projects (`themePath`, `Factory::factorize()`); keep them out of `Readme.md`.
2. **Test** in `dev/phpunit/tests/Rules/<NodeCategory>/<Name>RuleTest.php`:
   - Extend `Lipe\Lib\Phpstan\Rules\AbstractTestCase`; implement `provideCasesWhereAnalysisShouldSucceed()` and `provideCasesWhereAnalysisShouldFail()` as generators of named cases.
   - Each failure case is `[ path, [ message, line ] ]`. The message includes the tip, joined as `"...\n    💡 <tip>"`.
   - `use \StaticRule;` and return `self::staticRule( new XRule() )` from `getRule()` so one rule instance sees every fixture, surfacing state leaks.
   - Variants with different parameters are separate test classes (`FinalRuleWithAbstractClassesAllowedTest`).
3. **Fixtures** in `dev/phpunit/fixtures/<NodeCategory>/<TestVariant>/{Success,Failure}/`, one scenario per file. Fixture classes use namespace `Lipe\Lib\Phpstan\Rules\Test\Fixture\...` (autoload-dev).

The rules stay opt-in only because `rules.neon` scans `src/Rules` while `extension.neon` scans `src/Services`. Scanning `src` from `extension.neon` would turn every rule on for every consumer of the package.

User-facing rules are also listed in `Readme.md` under "Optional Included Rules"; rules affected by `nonDistributed: false` are listed again under "Distributed plugins or themes".
