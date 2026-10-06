---
name: "{{skill-name}}"
description: "Project-specific domain knowledge and workflows for {{skill-name}}. Activate for the tasks explicitly routed here by the project's guidelines."
license: MIT
---

# {{skill-name}}

This is a starting template. Adapt the description to a specific task scope and fill in verified domain knowledge before using the skill. Unfilled bracketed fields are unknowns, not instructions or facts.

## Scope

[Describe the domain workflows, integration, or operations this skill supports. State the relevant boundaries.]

## Contracts and Sources

[Record authoritative specifications, API contracts, documentation, and relevant source locations.]

For API work, inspect only the relevant operations and schemas before implementation. If the contract is unavailable or ambiguous, report uncertainty rather than inventing endpoints or behavior.

## Domain Rules

[Record business invariants, supported states, units, ordering requirements, failure handling, and integration-specific constraints.]

## Project Decisions

[Record intentional design and review exceptions with their scope and reason. Do not turn them into exemptions from correctness or security checks.]

## Verification

[Identify meaningful scenarios, test commands, fixtures, and effective isolation safeguards relevant to this domain.]

Apply the shared testing policy at `vendor/maarsson/agent-guidelines/resources/guidelines/testing.md`. For external integrations, also apply `vendor/maarsson/agent-guidelines/resources/guidelines/external-integrations.md`.
