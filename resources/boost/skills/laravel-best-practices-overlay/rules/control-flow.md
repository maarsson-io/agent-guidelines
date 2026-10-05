# Control Flow

## Branching

Prefer `match` over `switch` for value mapping. For substantial branching behavior, consider separate operations or polymorphism only when the benefit justifies the extra structure.

When replacing existing branching as part of an explicitly requested change, preserve the intended contract: strict comparison, exhaustive cases, and fallback behavior can make `match` behave differently from `switch`.

Use early returns and guard clauses to keep the main path flat and readable.

## Exceptions

Prefer explicit results for expected negative business outcomes where they make the contract clearer. Do not turn this into a ban on domain exceptions or Laravel's validation, authorization, and not-found exception mechanisms.

Catch the narrowest exception type that the code can meaningfully handle. Broader catches may be appropriate at an intentional error-handling boundary; avoid catching everything merely to conceal failure.

Use `try`/`catch` when it has a concrete role, such as recovery, translating a dependency failure, or attaching necessary context. There is no general prohibition on `try`/`catch`.

Keep exception and log messages stable for the same failure class. Put changing identifiers and diagnostic values in structured context rather than interpolating them into the message. Context must respect the privacy and sensitive-data rules (`vendor/maarsson/agent-guidelines/resources/guidelines/privacy-and-gdpr.md`).

## Return Contracts and Conditions

Prefer predictable, explicitly typed return contracts. Use nullable or result types where absence or failure has distinct meaning; use empty collections where they correctly represent no results. Do not mechanically replace missing values with empty strings or collapse distinct outcomes just to keep one type.

Prefer explicit comparisons when a condition needs to distinguish `null`, `false`, zero, and an empty value. Negating a known boolean with `!` is acceptable. Intent-revealing helpers are appropriate when an empty-value test is genuinely intended.

## Domain Values

Replace unexplained business numbers and strings with meaningful constants or backed enums. Prefer enums for defined value sets such as statuses, roles, and types. Do not extract every obvious literal merely to avoid literals.
