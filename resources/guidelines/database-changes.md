# Database Changes

## Execution Boundary

Agent database access is read-only except for automated tests running against a verified, isolated test database. Outside this exception, never execute code that modifies database schema or data, including modifying SQL statements, migrations, seeders, or database-writing Artisan commands and Tinker code.

## Before Running Database-Writing Tests

Apply this procedure to existing tests as well as new tests, regardless of the testing framework. It also applies when an agent invokes a script, quality-check suite, or Git hook that runs these tests indirectly.

`RefreshDatabase` can execute `migrate:fresh` during test setup. Other setup code, factories, seeders, and custom connections can also write data; calling the operation a test does not establish isolation.

Before running these tests:

- Read the relevant test setup and project test configuration to identify every database connection the selected tests can write to.
- Verify the effective database targets, including relevant environment overrides and test-specific connection changes. A testing environment name or a connection name alone does not establish isolation.
- Check whether cached application configuration is active. Cached database settings can take precedence over values declared in the test runner configuration and direct migrations or writes to a development or production database.
- Confirm that every write target is an isolated test database. If isolation cannot be verified, report the limitation and do not run the affected tests.

Reuse verified findings within the same execution context while the relevant configuration, environment, cache state, and test setup remain unchanged. Recheck when any of these changes or new evidence makes the previous verification insufficient.

An early test-setup guard can provide additional protection, but it must verify the actual isolated target rather than trusting a name such as "testing". Migrations, factories, seeders, and other database writes are permitted only as part of the verified test run.

## Planning and Implementation

Treat database changes as production-sensitive. Never assume a migration will run against an empty database or clean legacy data.

For data writes and concurrent operations, apply the [data integrity and concurrency guidelines](data-integrity-and-concurrency.md).

For schema or data changes, consider:

- existing rows, nullable values, and unexpected legacy values
- backwards compatibility and application/schema compatibility during deployment
- migration execution time and locking implications
- safe incremental migration where appropriate
- rollback limitations and recovery strategy

Never modify an existing migration that may already have been executed. Create a new migration instead.

Include destructive schema or data operations only when explicitly required. Do not remove columns or other persisted data structures without explicit instruction and consideration of existing production data.

Clearly identify operations that may:

- delete data or irreversibly transform it
- drop columns or tables
- change identifiers or relationships
- create significant locks or downtime

Do not assume that a migration rollback can restore deleted or transformed production data.

When a risky data transformation is required, prefer a strategy that allows the result to be verified before old data is removed.
