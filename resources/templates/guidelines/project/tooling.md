# Development Tooling and Git Conventions

Apply `vendor/maarsson/agent-guidelines/resources/guidelines/code-quality.md`.

Record configured checks and actual commands; do not assume a tool is configured because it is mentioned in a shared guideline.

| Check | Configuration | Check or dry-run command | Automation |
| --- | --- | --- | --- |
| [Tool] | [Configuration path] | [Configured command] | [CI, hook, manual, or none] |

- Known legacy findings and comparison scope: [Current evidence; verify again when relevant.]
- Scripts or hooks that also run tests: [Commands and the test suites they invoke.]

## Git Conventions

- Commit-message format and limits: [Configured rules.]
- Branch naming and protected branches: [Actual branch rules.]
- Git hooks and CI configuration: [Relevant paths.]
- Agent commit and push permissions: [Maintainer's explicit workflow.]

Use the current configurations and hooks as evidence. Before invoking a script or hook that runs tests, apply the shared testing policy and the [project test configuration](testing.md).
