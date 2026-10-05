# maarsson/agent-guidelines

Reusable, opinionated guidelines and skills for AI coding agents.

<div aria-hidden="true">

[![License](https://img.shields.io/github/license/maarsson-io/coding-standard)](https://github.com/maarsson-io/coding-standard/blob/master/LICENSE)

</div>

Shared instructions are intended for use across projects. Project-specific templates provide a starting point for local rules and context. Also an additive overlay for Laravel Boost.

## How instructions are loaded

When this package is selected during Laravel Boost setup, Boost includes the contents of `resources/boost/guidelines/core.blade.php` in the consumer project's `AGENTS.md`. The core contains shared instruction priorities and routing to guidelines and skills loaded only when relevant.

The consumer project can keep its own local instructions in separate files:

- `.agents/guidelines/maintainer.md`: replaces the package's default maintainer profile when present.
- `.agents/guidelines/project.md`: provides the project-specific guideline index, routing to local context, rules, and skills.

The package's `maintainer.md` and `project.md` guidelines check for these local files and load them when present.
