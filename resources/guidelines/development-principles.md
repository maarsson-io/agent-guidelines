# Development Principles

When working on an existing production application, work with its existing architecture rather than assuming a greenfield application.

Prefer pragmatic solutions with a concrete benefit.

For new implementations, prefer files with one clear responsibility. Split files when unrelated concerns make them harder to understand or maintain, rather than enforcing a fixed size limit.

Introduce additional processes, architectural complexity, or abstractions only when their benefit justifies their implementation and ongoing maintenance cost.

Prefer Laravel-native functionality and established Laravel conventions unless maintained project rules prescribe otherwise.

Prefer:

- incremental changes over broad rewrites
- explicit behavior over hidden magic
- correctness and maintainability over cleverness

## Comments

In all code, comments should explain non-obvious reasons, business constraints, external limitations, deliberate trade-offs, ordering requirements, or relevant upstream issues. Do not narrate code that is already clear.

Keep change-history annotations such as "new", "updated", and "previously" in Git history rather than in source comments. This does not exclude comments explaining why a current compatibility workaround exists.

## Version Compatibility

Use patterns and APIs compatible with the project's installed framework, library, and runtime versions, including when adding new code to a legacy application. Verify the relevant versions and configuration before applying version-specific guidance.

Keep version-independent principles applicable across projects. State compatibility requirements alongside version-specific recommendations in maintained guidelines and skills, and apply them only when those requirements are met. Modern best-practice guidance alone does not authorize dependency upgrades, migrations, or convention-only rewrites of existing code.

## PHP

Prefer readonly properties where appropriate.

Prefer enums over constants where they represent a defined set of values.
