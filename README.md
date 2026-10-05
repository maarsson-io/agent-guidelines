# maarsson/agent-guidelines

Reusable, opinionated guidelines and skills for AI coding agents.

<div aria-hidden="true">

[![Latest Stable Version](https://img.shields.io/github/v/release/maarsson-io/agent-guidelines?label=Latest)](https://github.com/maarsson-io/agent-guidelines/releases)
[![Test](https://github.com/maarsson-io/agent-guidelines/actions/workflows/validate.yml/badge.svg?branch=master)][GHA-test]
[![License](https://img.shields.io/github/license/maarsson-io/agent-guidelines)](https://github.com/maarsson-io/agent-guidelines/blob/master/LICENSE)

[GHA-test]: https://github.com/maarsson-io/agent-guidelines/actions/workflows/validate.yml

</div>

Shared instructions are intended for use across projects. Project-specific templates provide a starting point for local rules and context. Also an additive overlay for Laravel Boost.

## Install

Run these commands in the consumer Laravel project:

```bash
composer require --dev maarsson/agent-guidelines
php artisan boost:install
```

Composer also installs Laravel Boost if needed. If Boost is already configured, rerun its installer to enable this package.

In the installer, enable guidelines and skills, select your coding agents, and tick **`maarsson/agent-guidelines`** when prompted: "Which third-party AI guidelines/skills would you like to install?"

Boost saves this selection in `boost.json`. It includes this package's core guideline in the selected agents' instruction files and copies the four skills, including their supporting files, into the agents' skills directories. See the [Laravel Boost documentation](https://laravel.com/framework/docs/13.x/boost) for agent setup details.

> ### Non-interactive installation
>
> `php artisan boost:install --no-interaction` uses the package selection already saved in `boost.json`; it does not opt into third-party packages automatically.
>
> Commit the consumer project's configured `boost.json` before running the installer non-interactively. Ensure its `packages` array includes `maarsson/agent-guidelines`, preserving any other selected packages. For example, a Codex setup with guidelines and skills enabled:
>
> ```json
> {
>     "agents": ["codex"],
>     "guidelines": true,
>     "packages": ["maarsson/agent-guidelines"],
>     "skills": [
>         "laravel-best-practices-overlay",
>         "vue-frontend-best-practices",
>         "specification-driven-development",
>         "code-reviewing"
>     ]
> }
> ```
>
> Adapt this example to your agents and features; preserve other installed skills in an existing configuration.

## How instructions are loaded

When this package is selected during Laravel Boost setup, Boost includes the contents of `resources/boost/guidelines/core.blade.php` in the consumer project's `AGENTS.md`. The core contains shared instruction priorities and routing to guidelines and skills loaded only when relevant.

The consumer project can keep its own local instructions in separate files:

- `.agents/guidelines/maintainer.md`: replaces the package's default maintainer profile when present.
- `.agents/guidelines/project.md`: provides the project-specific guideline index, routing to local context, rules, and skills.

The package's `maintainer.md` and `project.md` guidelines check for these local files and load them when present.

## Included skills

| Skill | Purpose |
| --- | --- |
| [laravel-best-practices-overlay](resources/boost/skills/laravel-best-practices-overlay/SKILL.md) | Design defaults for new Laravel/PHP implementations and Blade templates, complementing Boost without requiring convention-only legacy rewrites. |
| [vue-frontend-best-practices](resources/boost/skills/vue-frontend-best-practices/SKILL.md) | Design defaults for new Vue components and pages, including presentation, notifications, and localization, respecting the installed Vue/Nuxt version. |
| [specification-driven-development](resources/boost/skills/specification-driven-development/SKILL.md) | Define intent, write specifications before implementing new features or comprehensive changes, and verify the result against them. |
| [code-reviewing](resources/boost/skills/code-reviewing/SKILL.md) | Read-only review of selected changes for concrete defects, regressions, and production risks. |

## Guideline topics

The [shared guidelines](resources/guidelines/) cover:

- Maintainer context, responsibilities, and development principles.
- Backend and frontend development.
- Database safety, data integrity, and concurrency.
- Privacy, external integrations, dependencies, and operational impact.
- Code quality, testing, and documentation.
- Routing to the consumer project's local guidelines and skills.

See [core.blade.php](resources/boost/guidelines/core.blade.php) for instruction priorities and the detailed guideline and skill routing.
