# Testing

Write automated tests for every new feature. For bug fixes and other changes, add or update tests when they provide meaningful behavioral coverage or regression protection. Hotfixes, minor fixes, and frontend styling changes do not automatically require new tests.

Before refactoring, write tests that capture the existing behavior and ensure they pass before changing the implementation. Run these tests after refactoring to verify that the behavior remains unchanged.

Use the project's configured testing framework, including Pest where the project uses it. Do not convert tests between Pest and PHPUnit unless explicitly requested by the user.

Code that compiles, passes quality checks, or looks idiomatic is not sufficient evidence of behavioral correctness.

## Database Isolation

Before running tests that can modify database schema or data, apply the [database execution procedure](database-changes.md). Read the relevant test configuration through the [project guideline index](project.md), including when running existing tests without changing code or invoking a command that runs tests indirectly.

## Network Isolation

Automated tests must not contact real external services. Use client-specific fakes and protection that makes unexpected or unmocked requests fail for every HTTP client or transport exercised by the tests. A guard for one client does not protect other clients or direct network access.

Missing recorded fixtures must fail rather than trigger a real request to record them. Use test-only endpoint configuration and dummy credentials for external integrations, without relying on live service settings inherited from the development or production environment. These are additional safeguards, not substitutes for network isolation.

Before running tests that can make outbound requests, verify that the relevant protections are effective. If isolation cannot be verified, report the limitation and do not run those tests.

## Test Design Guidance

When designing, writing, or reviewing Laravel tests, apply the `testing-best-practices` skill when available, together with the maintainer's [testing overlay](../boost/skills/laravel-best-practices-overlay/rules/testing.md). The overlay takes precedence over conflicting generated test guidance.
