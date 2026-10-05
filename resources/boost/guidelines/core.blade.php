# maarsson/agent-guidelines

Opinionated guidelines and skills for Laravel projects, complementing Laravel Boost.

## Instruction Priority

Explicit user instructions and maintained project-specific rules and exceptions take precedence over this package's shared defaults.

Maintained guidelines and skills listed below from `maarsson/agent-guidelines` override conflicting Boost-generated guidance, other package-provided skills, and legacy code conventions. Generated guidance is supplementary and applies only where consistent with these rules, even when phrased as mandatory.

Use existing conventions only where the maintained rules do not prescribe an approach and the existing pattern is correct.

## Execution Boundaries

Verify assumptions that materially affect correctness before relying on them.

Do not silently change existing application behavior outside the requested scope.

Never execute code that changes database schema or data, or write directly to a database, except as part of automated tests running against a verified, isolated test database.

## Context Loading

Read only the guidelines and skills relevant to the task. Follow each skill's declared scope. Preferences for new implementations do not authorize convention-only rewrites of legacy code.

Project templates are starting points for local instructions, not facts about the current application. Apply their project-specific content only after the maintainer has adapted it to the application.

## Guideline Routing

Paths are evaluated from the consumer application's root, not from this source file. Shared guideline filenames below are relative to `vendor/maarsson/agent-guidelines/resources/guidelines/`.

| When | Shared guideline |
| --- | --- |
| At the start of every task | `maintainer.md` |
| When working on this application | `project.md` |
| Before planning, implementing, or reviewing a change | `responsibilities.md` |
| When choosing or reviewing a solution | `development-principles.md` |
| When planning, implementing, or reviewing Laravel backend changes | `backend-development.md` |
| When planning, implementing, or reviewing frontend changes | `frontend-development.md` |
| Before planning, implementing, reviewing, or running database-related code | `database-changes.md` |
| When planning, implementing, or reviewing data writes or concurrent operations | `data-integrity-and-concurrency.md` |
| When working with personal or sensitive data, or reading application database records, logs, or monitoring events | `privacy-and-gdpr.md` |
| When planning, implementing, or reviewing external integrations | `external-integrations.md` |
| When changes affect deployment or production operations | `operational-impact.md` |
| When planning, implementing, or reviewing dependency, framework, or runtime changes | `dependencies.md` |
| When writing, reviewing, or verifying code | `code-quality.md` |
| When planning, implementing, reviewing, or verifying code changes, or running tests directly or through scripts or hooks | `testing.md` |
| When planning, implementing, or reviewing new features, comprehensive changes, or changes to documented behavior | `documentation.md` |

## Skill Activation

The following skills are maintained by this package. When installed, activate them for the corresponding tasks; do not wait until an implementation or review gets stuck.

| When | Activate skill |
| --- | --- |
| When planning, writing, or reviewing new Laravel/PHP implementations, including new code within existing files | `laravel-best-practices-overlay` |
| When planning, writing, or reviewing new Vue frontend implementations, following the installed Vue/Nuxt version | `vue-frontend-best-practices` |
| When planning or implementing new application features or comprehensive changes | `specification-driven-development` |
| When asked for code review or pre-commit/pre-merge assessment | `code-reviewing` |

For supporting skills supplied by Boost or other packages, activate them when installed and relevant:

| When | Activate skill |
| --- | --- |
| When debugging Laravel requests, jobs, exceptions, queries, or cache behavior and Telescope is installed | `telescope-debugging` |
| When configuring Nightwatch sampling, filtering, or redaction | `configure-nightwatch` |
| Only when explicitly asked to infer or record Laravel application code conventions | `infer-conventions` |

The `infer-conventions` skill must not run automatically. Inferred legacy conventions do not override maintained rules.
