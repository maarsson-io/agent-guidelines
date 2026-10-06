# General Design

## Reuse Before Adding Code

Before writing a new solution, determine whether it is needed, whether a suitable existing implementation can be reused, and whether PHP, Laravel, or an installed dependency already solves the problem.

Prefer the smallest coherent implementation that satisfies the scope. Do not add speculative features, parallel mechanisms, or abstractions without a concrete benefit. Do not simplify away validation, security, accessibility, or data-integrity protections.

Do not automatically delete unrelated legacy code that appears unused. Report it separately under the scope and responsibilities rules (`vendor/maarsson/agent-guidelines/resources/guidelines/responsibilities.md`); removal requires an appropriate task scope and evidence that the code is not used.

## Helpers

A small, deterministic, cross-cutting operation with no I/O or mutable state may be a free function if no existing model, service, or framework operation is a better home.

Prefer an existing suitable helper or operation over creating a new helper system. Keep stateful, database, filesystem, and service-dependent behavior in appropriate classes. Follow the project's autoloading and naming conventions when a new helper is justified.

## Strings

Prefer interpolation for simple strings containing values; use `sprintf` or an appropriate formatter when widths, padding, or numeric formatting matter. Simple concatenation is acceptable. Use single quotes for literals where appropriate.

The stable exception/log-message rule still applies: diagnostic identifiers belong in context rather than in interpolated messages.

## Complete PHPDoc

Write complete, consistent PHPDoc for new PHP classes, properties, methods, and functions. Include parameter and return information where applicable even when the signature already declares those types. Keep the documentation accurate as the new implementation evolves.

Include the additional precision needed by PHPStan/Larastan and IDE tooling: relation generics, collection element types, array shapes, and other types that native PHP declarations cannot express. Document meaningful thrown exceptions, deprecations, and non-obvious contracts where applicable.

Do not remove PHPDoc merely because some information duplicates a signature. Full PHPDoc does not justify repetitive inline narration or rewriting documentation on unrelated legacy declarations.
