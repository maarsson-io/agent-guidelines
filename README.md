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
vendor/bin/agent-guidelines-init
vendor/bin/agent-guidelines-link-skills
php artisan boost:install
```

Composer also installs Laravel Boost if needed. If Boost is already configured, rerun its installer to enable this package.

The linking command creates `.agents/skills` as the canonical directory, with `.claude/skills` and `.github/skills` pointing to `../.agents/skills`. Run it before the Boost installer so the selected agents share the same skills, including your own local skills and those installed by Boost.

The command preserves existing skills and correct symlinks, and can be rerun. It refuses conflicting files, real skill directories, or links pointing elsewhere. If Boost has already created separate skill directories, move or merge their contents manually before linking. The `.agents`, `.claude`, and `.github` parent directories must be real directories.

By default, it uses the current directory; you can also pass a project directory:

```bash
vendor/bin/agent-guidelines-link-skills /path/to/consumer
```

To run it through Composer, add a script to the **consumer project's** `composer.json`:

```json
{
    "scripts": {
        "agent-skills:link": "agent-guidelines-link-skills"
    }
}
```

Then run `composer agent-skills:link`. Merge this entry into any existing scripts. Dependency packages' own Composer scripts do not run automatically.

In the installer, enable guidelines and skills, select your coding agents, and tick **`maarsson/agent-guidelines`** when prompted: "Which third-party AI guidelines/skills would you like to install?"

Boost saves this selection in `boost.json`. It includes this package's core guideline in the selected agents' instruction files and copies the package’s skills, including their supporting files, into the agents' skills directories. See the [Laravel Boost documentation](https://laravel.com/framework/docs/13.x/boost) for agent setup details.

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
>         "laravel-permissions",
>         "specification-driven-development",
>         "code-reviewing"
>     ]
> }
> ```
>
> Adapt this example to your agents and features; preserve other installed skills in an existing configuration.

## Project-specific guidelines and skills

The [templates](resources/templates/) provide a local project index and separate files for context, backend, frontend, documentation locations, tooling, testing, integrations, and infrastructure. The initializer creates missing files under `.agents/guidelines/` and skips existing files. Adapt the templates to verified project facts; placeholders do not establish facts or exceptions.

The package's shared `project.md` delegates to `.agents/guidelines/project.md`. That local index routes to the relevant project files. Shared rules remain in the installed package; local rules and explicit exceptions take precedence.

The default maintainer profile remains active unless the consumer has its own `.agents/guidelines/maintainer.md`. To create a local replacement template explicitly:

```bash
vendor/bin/agent-guidelines-init --maintainer
```

For domain or integration skills, create an editable source with a descriptive name:

```bash
vendor/bin/agent-guidelines-init --skill=project-integration
```

This creates `.ai/skills/project-integration/SKILL.md`. Adapt its description, scope, contracts, and rules, then add the skill's name and activation conditions to the relevant local guideline, such as `project/context.md` or `project/integrations.md`.

Run `php artisan boost:install` after adapting a new skill, or `php artisan boost:update` to sync custom skills in an already configured project. Boost discovers the maintained sources in `.ai/skills/` and installs them in the shared `.agents/skills/` directory when the skill-directory links are configured. Keep these local sources in the consumer repository; they are not files maintained by this package.

The initializer does not invoke Boost or create skill-directory links. Run `agent-guidelines-link-skills` before the Boost installer as shown above. Both initialization options may be combined, and an optional project-directory argument is supported. No existing file is overwritten; symlinked parent directories and directory conflicts are rejected.

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
| [laravel-permissions](resources/boost/skills/laravel-permissions/SKILL.md) | Permission-based authorization rules using Laravel Policies, FormRequests, visibility scopes, and Spatie permissions. |
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
