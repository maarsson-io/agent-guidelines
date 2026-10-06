# Test Configuration

Apply `vendor/maarsson/agent-guidelines/resources/guidelines/testing.md`. Before database-writing tests, follow `vendor/maarsson/agent-guidelines/resources/guidelines/database-changes.md`.

- Framework and relevant configuration: [Pest/PHPUnit or other tools, and configuration paths.]
- Test commands and suites: [Configured commands and test layout.]
- Intended database targets: [Engine, database, and connections; identify isolated test targets.]
- Database-writing setup: [RefreshDatabase, factories, seeders, or other actual setup.]
- Environment overrides and cached configuration: [Relevant files and precedence.]
- Outbound clients and effective network guards: [Each client or transport and how unexpected requests are blocked.]
- Integration fixtures and test-only settings: [Fixture behavior, dummy credentials, and endpoint configuration.]

Recorded intended settings do not replace verification of effective database and network isolation before running affected tests.
