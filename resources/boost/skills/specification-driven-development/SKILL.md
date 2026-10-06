---
name: specification-driven-development
description: Deliver new application features and comprehensive changes from a human-defined specification written before implementation. Use when planning or implementing these scopes; routine small fixes and styling changes do not require this workflow.
---

# Specification-Driven Development

Shared guideline paths in backticks are relative to the consumer application root. Markdown links are relative to the file containing them.

Follow the documentation guideline (`vendor/maarsson/agent-guidelines/resources/guidelines/documentation.md`) for applicability, document types, content, and maintenance. Resolve the project's configured documentation locations and conventions through the project guideline index (`vendor/maarsson/agent-guidelines/resources/guidelines/project.md`). Update a relevant specification rather than creating a competing document.

## 1. Conceptual Planning

Inspect the relevant existing behavior and constraints. Identify the proposed scope, affected workflows, dependencies, and material risks. Separate the conceptual solution from detailed code design; do not start implementation before the intended behavior is specified.

## 2. Define Goals and Intent

Establish the problem, desired outcome, intended behavior, boundaries, and important decisions from the user's instructions and existing agreed context.

Ask about unresolved intent only where it materially affects the scope or correctness. Do not infer business intent from legacy code or silently settle an ambiguous requirement. Do not ask for confirmation again when the existing context already establishes a decision.

## 3. Write the Specification

Write the specification before implementation using the guideline's relevant sections. For changes to existing functionality, make clear which behavior changes and which must remain compatible.

Include observable acceptance criteria within Behavior or Important details: the outcomes and relevant failure or boundary conditions that will demonstrate completion. Keep them proportionate to the scope; avoid an implementation blueprint or an exhaustive theoretical checklist.

Distinguish established decisions from open questions. Resolve questions that block correct implementation before implementing the affected behavior. The written specification should be available for the user to review; writing it does not create an additional approval gate unless the user requested one.

## 4. Implement Against the Specification

Implement the specified scope using the maintained development, testing, and code-quality rules. Use the acceptance criteria to guide meaningful behavioral coverage. Where the work includes refactoring, apply the testing guideline (`vendor/maarsson/agent-guidelines/resources/guidelines/testing.md`), including tests before refactoring.

If implementation reveals a missing requirement or conflict, establish the intended resolution before changing affected behavior. Update the specification to reflect agreed decisions alongside implementation; do not change it merely to justify accidental deviations.

## 5. Verify Conformance

Compare the final implementation with the specification's intended behavior, requirements, constraints, and acceptance criteria. Inspect relevant paths and run the appropriate tests and checks within the project's execution restrictions.

Check for omitted behavior, unintended additions, and discrepancies between documented and actual outcomes. Fix implementation defects; clarify unresolved intent rather than declaring conformance without evidence.

Keep the specification and code consistent. After verification, complete the relevant implementation documentation and user instructions under the guideline's documentation-type rules, keeping them distinct from the specification. Report what was implemented and verified, and any remaining deviations, open questions, or verification limits. Passing tests alone does not establish that the agreed specification was fulfilled.
