# Documentation

## When Documentation Is Required

Use specification-driven development for every new feature and comprehensive change. Define the goals and intended behavior after conceptual planning, write the specification before implementation, then verify the implementation against it. When implementing such a scope, apply the [specification-driven development skill](../boost/skills/specification-driven-development/SKILL.md).

Small bug fixes, hotfixes, minor adjustments, and frontend styling changes do not require a new specification merely because code changes.

Whenever a change affects behavior, requirements, constraints, or decisions already documented, update the relevant documentation. If no related documentation exists, a small change does not require creating it. Do not turn a task into documentation of the entire legacy system.

These requirements take precedence over conflicting generated guidance restricting documentation to explicit requests. Required documentation is part of the implementation, not a later reminder or follow-up task.

## Documentation Types

Keep these document types distinct:

| Type | When | Purpose and audience |
| --- | --- | --- |
| Specification | Before implementation | Agreed goals, intended behavior, requirements, and acceptance criteria for implementation and review. |
| Implementation documentation | After implementation and verification | Meaningful technical decisions, implementation-specific constraints, and operational information for developers and maintainers. |
| User manual | After the relevant behavior is implemented and verified | Workflows and usage instructions for human users. |

Write or update implementation documentation when the change introduces technical or operational information that needs explanation. Write or update user instructions when the changed workflow needs guidance. Do not create all three documents mechanically for every change.

Implementation documentation must describe the verified implementation without duplicating the specification or becoming a prose copy of the code. Keep developer and operational details out of the user manual unless users need them to perform their work.

## Project Conventions

Consult the [project guideline index](project.md) for documentation locations, format, and naming. Use the configured locations even when the relevant directory needs to be created for its first document. Update a relevant existing document rather than creating a competing one.

## Intent and Content

The human provides the goals, business intent, and decisions. The agent structures and formulates them, derives factual supporting details, and identifies missing or ambiguous context. Do not invent purpose or intended business behavior from the implementation alone.

Write concise documentation for its intended audience. For specifications, use the following sections where they have meaningful content:

1. **Purpose:** the problem and intended outcome.
2. **Behavior:** intended business or system behavior and chosen decisions.
3. **Requirements:** configuration, data, external dependencies, and business prerequisites.
4. **Important details:** non-obvious decisions, exceptions, constraints, and behavior.
5. **Related resources:** relevant documentation, specifications, APIs, and source material.

Describe intended outcomes precisely enough to guide implementation and verification. Do not repeat class structures, method names, namespaces, internal call chains, or framework conventions that are clear from the code. Omit empty sections and detail added solely for completeness.

The specification records agreed intent; code establishes actual implementation. A mismatch must be resolved, not hidden by rewriting the specification to match unintended behavior.

## Maintenance and Review

Keep the specification current as agreed decisions evolve. Keep related documentation and implementation in the same scope and, where practical, the same commit or pull request.

For required documentation, consider the implementation incomplete while the relevant specification is missing, outdated, or materially unverified against the implementation.

During code review, use the relevant specification to check completeness and conformance to intent, alongside correctness, regression analysis, and the other maintained project rules.
