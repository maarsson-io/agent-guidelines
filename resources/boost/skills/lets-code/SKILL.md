---
name: lets-code
description: Apply execution rules when the AI writes or modifies code, preserving requirements, documentation, testing, and developer control over Git history.
---

# Let's Code

Use this skill when the AI writes or modifies code.

This skill defines implementation and verification rules. Also apply `specification-driven-development` when its scope applies; using this skill does not expand that scope or relax the workflow's requirements or the maintained guidelines.

## Before implementation

Find out whether the current scope has:

- a specification
- implementation documentation
- a user manual

Look for them in the project's configured documentation locations and in what was provided when the skill was invoked. Do not ask whether a document exists when that can be determined by inspection.

For each one that does not exist, ask whether it is required for the current scope, unless the request or existing context already settles it. Do not assume that missing documentation is unnecessary.

## Source of truth

If a specification exists, treat it as the authoritative source of truth for intended behavior and requirements.

- Do not change, reinterpret, extend, or simplify requirements that are explicitly defined in the specification.
- Do not invent customer requirements, business rules, or implementation constraints that are not supported by the specification or existing project context.
- Inspect the existing codebase before implementing changes.
- Preserve existing behavior unless the specification explicitly changes it.
- If the specification is ambiguous, incomplete, internally inconsistent, or conflicts with an important existing constraint, stop that decision and raise it explicitly for discussion rather than resolving it through assumption.

## Implementation

Work incrementally and keep each change within the current implementation scope.

Follow existing project conventions and established project skills unless the specification explicitly requires otherwise.

For changes with meaningful production, security, data-integrity, or migration risk:

- identify relevant failure modes;
- preserve backwards compatibility where required;
- account for existing production data;
- make changes verifiable;
- avoid unnecessary architectural changes outside the current scope.

Do not perform unrelated refactoring unless it is required for correctness or explicitly requested.

## Testing

Prioritize tests that directly verify the current implementation scope.

- Add or update focused tests for the behavior being implemented.
- Run the most relevant tests during development.
- Do not repeatedly run a large unrelated test suite when it provides little additional signal.
- Run broader existing tests when the scope can reasonably affect them or when final verification requires it.
- Existing tests must remain green.

If the affected area has little or no legacy test coverage, the new focused tests are the primary verification mechanism and must cover the important success, rejection, and boundary cases.

## Documentation

Documentation is part of the implementation. Update implementation documentation and the user manual at the end of each verified increment, covering the behavior that increment made final:

- when the scope is delivered as one increment, that is once, after final verification;
- when the scope is delivered in several increments, such as specification phases, separately reviewed steps, or work spanning multiple sessions, that is after each increment, before starting the next.

An increment is verified when its behavior is implemented and its relevant tests pass. Do not leave documentation of earlier increments to the end of the scope.

If implementation documentation exists or is required:

- write it for developers;
- keep it concise;
- document purpose, behavior, requirements, and non-obvious constraints rather than explaining code.

If a user manual exists or is required:

- write it for end users or administrators;
- document only behavior they need to understand or use;
- keep it concise and task-oriented.

Do not document speculative behavior before it is implemented or confirmed.

Keep documentation aligned when implementation decisions change during the work.

## Git operations

The developer retains control over Git history and remote operations.

Unless explicitly requested:

- do not stage files;
- do not create commits;
- do not amend commits;
- do not push;
- do not create tags.

The developer will review the completed changes before staging and committing them.

Never push unless explicitly instructed.
