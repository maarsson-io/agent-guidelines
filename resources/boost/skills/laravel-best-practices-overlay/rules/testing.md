# Testing Overlay

Apply these preferences to new test implementations, including new coverage within existing files. Do not reorganize existing tests solely to follow these defaults. Follow the maintained testing policy (`vendor/maarsson/agent-guidelines/resources/guidelines/testing.md`).

## Shared Safeguards and Scenario-Specific Fakes

Suite-wide safeguards and deterministic defaults may live in the base TestCase's `setUp()` when appropriate, such as blocking stray HTTP requests or controlling sleep and external exception reporting.

Keep scenario-specific fakes, responses, and expectations in the test that needs them. Shared defaults must not disable the behavior under test; configure or override them locally when coverage requires the real path.

## Test Classification and File Layout

Choose unit or feature tests according to the behavior and dependencies being exercised, not the production class's directory. Pure logic without framework dependencies can use unit tests; framework-dependent behavior belongs in feature tests.

Follow the project's existing test layout. Where mirroring the production path is useful, `app/Actions/DeleteTeam.php` may map to `tests/{Unit|Feature}/Actions/DeleteTeamTest.php`; choose the appropriate suite rather than treating `Unit` in a generated example as mandatory.

## Test Database Choice

Prefer SQLite/in-memory testing when it provides faithful coverage of the behavior. An independently verified, isolated MySQL test database is also acceptable; a `Connection: mysql` message alone is not evidence of unsafe targeting.

Choose configuration appropriate to the project rather than imposing a connection name, variable name, or universal `phpunit.xml` recipe. Before running database-writing tests, apply the shared database execution procedure (`vendor/maarsson/agent-guidelines/resources/guidelines/database-changes.md`).
