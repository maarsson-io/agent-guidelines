---
name: code-reviewing
description: Review staged changes, feature branches, or an explicitly selected diff for concrete defects, regressions, and production risks. Use for code review and pre-commit or pre-merge assessment; report findings without applying fixes.
---

# Code Reviewing

Shared guideline paths in backticks are relative to the consumer application root. Markdown links are relative to the file containing them.

Act as an independent senior reviewer. Identify defects, missing scenarios, and incorrect assumptions in the submitted change.

Review from the perspective of a senior engineer providing the second pair of eyes that would normally exist in a development team. When the maintainer works alone, this review is the independent check that a second developer would otherwise provide.

Review is read-only. Do not edit source files, tests, configuration, or documentation, or modify the Git index, branches, or history as part of review. Report findings and suggest corrections without applying them. Verification must respect the project's execution restrictions.

Review behavior, not just style. Challenge the implementation with realistic failure scenarios; clean code, compilation, passing tests, or AI authorship do not establish correctness.

## Workflow and References

- Read [workflow](references/workflow.md) to establish the target, investigation depth, and handling of incidental legacy defects.
- Read the relevant sections of [review checks](references/review-checks.md) for affected behavior. Do not apply every checklist to every change.
- Read [findings and output](references/findings-and-output.md) before classifying and reporting results.

Apply the maintained project rules and relevant framework or domain skills. They take precedence over conflicting legacy conventions.

For newly introduced implementations, read the relevant rules in the [Laravel overlay](../laravel-best-practices-overlay/SKILL.md) or [Vue frontend skill](../vue-frontend-best-practices/SKILL.md). These design preferences do not justify findings against unchanged legacy conventions or automatic refactoring; report concrete defects under this review skill's evidence and scope rules.

Use the shared guidelines for the concerns actually affected:

| Concern | Guidelines |
| --- | --- |
| Architecture and proposed corrections | Development principles (`vendor/maarsson/agent-guidelines/resources/guidelines/development-principles.md`) |
| Schema or data changes | Database changes (`vendor/maarsson/agent-guidelines/resources/guidelines/database-changes.md`) |
| Data writes, concurrency, or duplicate execution | Data integrity and concurrency (`vendor/maarsson/agent-guidelines/resources/guidelines/data-integrity-and-concurrency.md`) |
| External systems | External integrations (`vendor/maarsson/agent-guidelines/resources/guidelines/external-integrations.md`) |
| Test coverage and verification | Testing (`vendor/maarsson/agent-guidelines/resources/guidelines/testing.md`) |
| Specifications, intended behavior, and documentation requirements | Documentation (`vendor/maarsson/agent-guidelines/resources/guidelines/documentation.md`) |
| Personal or sensitive data | Privacy and GDPR (`vendor/maarsson/agent-guidelines/resources/guidelines/privacy-and-gdpr.md`) |
| Deployment and production operations | Operational impact (`vendor/maarsson/agent-guidelines/resources/guidelines/operational-impact.md`) |
