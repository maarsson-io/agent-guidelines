# Eloquent Opinions

## Soft Deletes

Prefer considering soft deletes for user-facing or auditable entities where undo, recovery, or retention matters. Decide per model; this is not mandatory and does not require documenting every decision to use ordinary deletion.

Respect actual retention and deletion requirements. Soft deletion is not itself a complete audit trail or permanent erasure.

## Relationship Identifiers

When only a foreign-key value is needed, prefer reading it directly from the owning model instead of loading a related model solely for its identifier.

Do not treat these operations as automatically equivalent: reading the key does not establish that the related record exists, is visible through the relationship's scopes, or is authorized for the caller.

## Transactions

Do not wrap every write in a transaction reflexively. Use transactions where multiple statements must succeed or fail together, or where a concurrency-control strategy requires a transaction. Keep the protected work focused on the actual invariant.

Avoid unnecessary transactions without weakening required consistency. Use appropriate constraints, locking, and atomic operations according to the data-integrity and concurrency guideline (`vendor/maarsson/agent-guidelines/resources/guidelines/data-integrity-and-concurrency.md`).

## New Money Representations

For a new, independently designed money representation, prefer integer amounts in a declared smallest unit rather than floating-point amounts. Make the unit and currency unambiguous; choose precision and rounding deliberately.

This does not require converting existing columns, calculations, API contracts, or payloads to integers. New code interacting with an existing money contract must preserve that contract and use explicit conversions where actually required.

Do not add a money package automatically. A value object or dependency is justified only by a concrete domain need under the project's dependency policy (`vendor/maarsson/agent-guidelines/resources/guidelines/dependencies.md`).
