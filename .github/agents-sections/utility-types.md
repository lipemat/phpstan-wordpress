# Utility types

Generic PHPDoc types (`\AtLeast`, `\Exclude`, `\Partial`, `\Pick`, `\Required`, `\Sarcastic`, `\Union`) resolved by `TypeNodeResolverExtension` classes. A type is complete when every file below exists; `Pick` is the reference set.

| Purpose                                                                   | File                                                                              |
|---------------------------------------------------------------------------|-----------------------------------------------------------------------------------|
| Resolver                                                                  | `src/Services/TypeNodeResolver/Pick.php`                                          |
| Registration (`phpstan.phpDoc.typeNodeResolverExtension` tag)             | `extension.neon`                                                                  |
| IDE placeholder class with `@template`s, so PhpStorm knows the name       | `dev/stubs/utility/Pick.php`                                                      |
| Preloaded `@phpstan-type` holder used by tests                            | `dev/stubs/pick-example.php`, listed in `dev/phpunit/tests.neon` `bootstrapFiles` |
| `assertType()` cases                                                      | `dev/phpunit/data/TypeNodeResolver/PickExample.php`                               |
| Test (`TypeInferenceTestCase` + `gatherAssertTypes`, config `tests.neon`) | `dev/phpunit/tests/Services/TypeNodeResolver/PickTest.php`                        |
| User docs                                                                 | `Readme.md` "Utility Types"                                                       |

Resolver behaviour:

- Match on `GenericTypeNode` whose type name is the leading-backslash form (`'\Pick'`); return `null` for anything else so other extensions get the node.
- Wrong argument count returns `null`; a non-array argument returns `new ErrorType()`.
- Resolve arguments through the injected `TypeNodeResolver` (`TypeNodeResolverAwareExtension`) and iterate `getConstantArrays()` so union-of-shape inputs work; combine with `TypeCombinator::union()`.
- Types must nest (`\AtLeast<\Union<\Pick<...>, ...>, 'k'>`); add a combined case to the data file.

Type-alias imports (`@phpstan-import-type`) only resolve when the alias holder is preloaded from `dev/stubs/*-example.php`; declaring it inside the data file is not enough.

`dev/phpunit/tests/Services/DynamicReturnTypeExtensionTest.php` with `dev/phpunit/data/get_*.php` asserts WordPress return types from `szepeviktor/phpstan-wordpress`; it guards upstream behaviour after dependency bumps.
