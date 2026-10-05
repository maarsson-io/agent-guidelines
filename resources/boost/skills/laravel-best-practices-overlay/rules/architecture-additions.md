# Architecture Additions

## Names and Responsibilities

Avoid method names joining unrelated responsibilities with "and". Split genuinely separate operations, or name the cohesive business concept rather than its constituent steps. Preserve required atomicity when composing operations.

Name methods in the context of their class without redundant repetition: prefer `cancel()` on an Order and `isActive()` on a User. Keep names informative; shortening a name to a vague `get()` is not an improvement.

## Visibility

Default internal methods to `protected`, following the maintainer's preference. Use `private` where preventing subclass access is justified. Make methods `public` for a concrete external API, interface, or framework requirement, not by habit.

## Dependency Injection

Constructor injection and method injection are both valid. Use constructor injection for dependencies shared across class operations, and method injection for dependencies specific to an operation or framework entry point. Do not require constructor injection exclusively.

## Thin Entry Points

Keep job, listener, and console-command `handle()` methods thin. Resolve inputs and dependencies, delegate business work to Services or Actions, and return the appropriate result.

Keep the reusable operation independent of HTTP and queue entry points, following the backend-development guideline (`vendor/maarsson/agent-guidelines/resources/guidelines/backend-development.md`). Do not create layers with no concrete benefit merely to relocate a trivial statement.

## Queue Selection

The default queue is acceptable for ordinary background work. Do not place long-running or resource-intensive jobs that could delay or disrupt normal processing on the default queue alongside ordinary work; prefer a dedicated queue with configured workers and suitable capacity.

Do not split notification channels into separate queues without a concrete operational benefit.

## Routes

Keep route files declarative. Put queries, data mutations, and business decisions in the appropriate operation behind a controller rather than in route closures.

Simple framework routing helpers remain appropriate. This rule is about keeping business logic out of route definitions, not banning every concise route mechanism.
