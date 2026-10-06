---
name: vue-frontend-best-practices
description: Apply the maintainer's frontend design defaults when planning, writing, or reviewing new Vue components and pages, including presentation, display values, toolbars, notifications, and localization. Follow the project's installed Vue/Nuxt version; does not authorize legacy UI redesigns.
license: MIT
---

# Vue Frontend Best Practices

Shared guideline paths in backticks are relative to the consumer application root. Markdown links are relative to the file containing them.

## Scope and Priority

Apply these defaults to newly written frontend implementations, including new components or behavior within existing files. Do not rewrite legacy pages or introduce a new frontend architecture just to enforce these preferences.

Explicit user instructions and maintained project guidelines take precedence. Use the project's installed Vue/Nuxt version, UI library, HTTP client, and correct existing patterns. Do not introduce Vue 3-only APIs into a Vue 2 project.

Use the established domain vocabulary for new identifiers, translation keys, and labels. Translated labels and English code identifiers can express the same concept without introducing developer-only synonyms. Existing naming contracts remain intact unless renaming is part of the task.

## Rule Routing

Read only the files relevant to the new implementation.

| Concern | Read |
| --- | --- |
| Component responsibilities, data preparation, reusable presentation | [Component design](rules/component-design.md) |
| Status labels, money, dates, boolean states, technical identifiers | [Display values](rules/display-values.md) |
| Page headers, breadcrumbs, page actions, shared controls | [Page toolbar](rules/page-toolbar.md) |
| Toasts, alerts, operation outcomes, validation feedback | [Notifications](rules/notifications.md) |
| User-facing text, domain keys, locale and fallback | [Localization](rules/localization.md) |

Apply the maintained frontend-development (`vendor/maarsson/agent-guidelines/resources/guidelines/frontend-development.md`), testing (`vendor/maarsson/agent-guidelines/resources/guidelines/testing.md`), and code-quality (`vendor/maarsson/agent-guidelines/resources/guidelines/code-quality.md`) guidelines. Do not demand automated tests for styling or trivial details without meaningful confidence under the testing policy.

Actual Blade PDF and email templates belong to the [Laravel overlay](../laravel-best-practices-overlay/SKILL.md). This skill does not grant permission to apply fixes during a read-only review.
