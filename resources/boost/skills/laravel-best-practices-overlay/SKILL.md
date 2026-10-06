---
name: laravel-best-practices-overlay
description: Apply the maintainer's selected design defaults when planning, writing, or reviewing new Laravel/PHP implementations and Blade PDF or email templates, including new code within existing files. Complements Laravel Boost; does not authorize convention-only rewrites of legacy code.
license: MIT
---

# Laravel Best Practices Overlay

Shared guideline paths in backticks are relative to the consumer application root. Markdown links are relative to the file containing them.

Complements Laravel Boost. When available, use the `laravel-best-practices` skill for framework mechanics and version-specific APIs, subject to the maintained instruction priority.

## Scope and Priority

Apply these design defaults to newly written implementations, including new methods or operations within existing files. Do not rewrite, rename, reformat, or remove existing code solely to make it follow these preferences. During review, do not report unchanged legacy conventions as defects merely because they differ.

Explicit user instructions and maintained project guidelines take precedence. These selected preferences take precedence over conflicting generated defaults. Respect established contracts and correct existing patterns where no maintained rule prescribes otherwise.

Do not migrate legacy money representations, introduce packages, or expand the task as a side effect of applying this skill.

## Rule Routing

Read only the files relevant to the implementation. Cross-cutting work may need several files.

| Concern | Read |
| --- | --- |
| Branching, exceptions, return contracts, boolean checks, domain constants | [Control flow](rules/control-flow.md) |
| Soft deletes, relationship identifiers, transactions, new money representations | [Eloquent opinions](rules/eloquent-opinions.md) |
| Method names, visibility, dependency injection, jobs, queue selection, listeners, commands, routes | [Architecture additions](rules/architecture-additions.md) |
| New domain and class names | [Naming](rules/naming.md) |
| Reuse, helpers, strings, complete PHPDoc | [General design](rules/general-design.md) |
| Test setup, fakes, unit/feature classification, test file layout | [Testing](rules/testing.md) |
| Database-writing tests or database commands | Database execution procedure (`vendor/maarsson/agent-guidelines/resources/guidelines/database-changes.md`) |
| Actual Blade templates, including PDF and mail rendering | [Blade views](rules/blade-views.md) |
| PHP-rendered labels, amounts, dates, and states | [Display values](rules/display-values.md) |
| Backend user-facing text, validation, mail, and PDF translations | [Localization](rules/localization.md) |

Vue components, page toolbars, and client notifications belong to the separate [Vue frontend skill](../vue-frontend-best-practices/SKILL.md). Do not apply Blade-specific mechanisms to Vue.

Apply the maintained testing (`vendor/maarsson/agent-guidelines/resources/guidelines/testing.md`) and code-quality (`vendor/maarsson/agent-guidelines/resources/guidelines/code-quality.md`) policies when verifying changes. This skill does not grant permission to apply fixes during a read-only review.
