# Review Workflow

## Target

Respect an explicitly requested review target. Otherwise, the default pre-commit target is the staged Git diff (`git diff --cached`). If there are no staged changes, report that rather than silently reviewing another target.

For a feature branch final review, establish the correct base branch and inspect the complete integrated change against it, normally using the merge-base diff (`git diff <base>...HEAD`). Verify the base rather than assuming its name.

Review the feature as a whole. Check for incomplete implementation across layers, forgotten callers, mismatched frontend/backend contracts, migrations inconsistent with final behavior, transitional code, duplicate implementations, and unintended scope expansion. Assess tests and deployment requirements against the final integrated behavior.

## Specification and Intent

Read any specification or existing documentation relevant to the reviewed scope. Apply the documentation guideline (`vendor/maarsson/agent-guidelines/resources/guidelines/documentation.md`) to determine what documentation is required.

Compare the implementation and meaningful test coverage with the intended behavior, requirements, constraints, and acceptance criteria. Check for omitted requirements, unintended behavior, and undocumented changes to agreed decisions. A specification does not replace tracing actual code or checking regressions.

If required documentation is missing or intent remains ambiguous, report the gap and its effect on the assessment. Do not invent requirements, create documentation, or run the implementation workflow as part of read-only review.

## Investigation Depth

Start with the diff, then inspect enough surrounding code to establish actual behavior and impact. Trace relevant callers, validation, authorization, models, schema, jobs, events, configuration, frontend consumers, and tests when correctness depends on them. Unchanged surrounding code must not be assumed to satisfy the new implementation's expectations.

Scale investigation to actual risk, including when several small changes are reviewed together. Comments, formatting, or documentation with no behavioral effect usually need only minimal surrounding context. Do not classify CI/CD or build tooling as low risk merely because of file type: inspect affected workflows and their relationships for deployment, permissions, secrets, artifacts, configuration, or execution effects.

Expand investigation to establish whether a suspected defect is real. Do not turn a review into an unrelated repository audit.

## Incidental Legacy Defects

Report every verified legacy defect discovered incidentally, regardless of severity, in a separate section outside the reviewed change's findings. Do not silently fix it or expand the review into a general audit.

An existing defect newly exposed or worsened by the submitted change belongs in the change's findings. Explain how the change makes it relevant.

## Verification

Support conclusions with code paths, callers, schema, framework behavior, tests, or reproducible scenarios. Run relevant verification only within the project's execution rules. Distinguish inspected code from commands or tests actually executed, and state material verification limits.
