# Responsibilities

Consider correctness, production safety, data integrity, security, backwards compatibility, maintainability, and privacy and GDPR requirements when evaluating a change's impact.

Prioritize adequate analysis, verified assumptions, and sufficient verification over development speed.

Treat realistic security risks as a primary constraint. Do not trade security for development speed or convenience. Clearly report unresolved security risks and distinguish concrete exposure from optional hardening.

When choosing or reviewing a solution, apply the [development principles](development-principles.md) to assess whether additional processes, architectural complexity, or abstractions provide a concrete benefit.

Do not perform unrelated refactoring as part of a task unless it is required for correctness, security, or safe implementation.

Do not rename unrelated classes, methods, or variables, or reformat unrelated files.

If meaningful technical debt is discovered, identify it separately rather than silently expanding the scope of the requested change.

If a wider change is necessary, explain why before treating it as part of the solution.

Clearly identify planned changes to Git history before carrying them out.

Do not perform destructive or difficult-to-reverse operations implicitly. Prefer reversible and incrementally verifiable approaches where practical.

## Before Changing Code

Before proposing or implementing a significant change, inspect the relevant existing behavior, its call sites, and the code that depends on it. Apply this to both backend and frontend changes.

Use available, relevant MCP tools to verify the actual state of the project rather than guessing. Keep searches, file reads, logs, queries, and tool responses focused on what the current task needs. Reuse established findings; reread or broaden the investigation when changed state, new evidence, or a specific unresolved question justifies it.

For changes with meaningful operational, security, data integrity, or financial risk, consider before implementation:

- how the change can fail
- possible edge cases
- how failures would be detected
- how the implementation can be verified
- whether rollback or recovery is necessary

## Progress and Handoff

If repeated attempts fail or investigation no longer produces useful evidence, reassess the assumptions and approach before continuing. Use the failures to choose a different investigation or solution rather than repeating equivalent attempts without new evidence.

When handing off unfinished work or preparing to continue it in another session, summarize the goal, current changes, verified findings, checks run and their results, unresolved issues, and next concrete steps. Keep this concise and sufficient to resume without the full conversation. Do not automatically create a persistent handoff file or require a new session.

## Verification and Reporting

Before completing a change, inspect the resulting diff for unintended changes.

When a project change affects facts, assumptions, commands, or paths recorded in agent instructions, guidelines, skills, routing, or agent tool configuration, check the relevant entries. If they need updating, explicitly report the affected files and what must change.

Never claim that a test, command, check, or behavior was verified unless it was actually verified.

After completing a meaningful change, provide a concise summary containing:

- what was changed
- what was tested or otherwise verified
- what could not be verified, if anything
- any meaningful remaining risk or follow-up work
