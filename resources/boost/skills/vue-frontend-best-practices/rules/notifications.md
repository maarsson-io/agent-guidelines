# Notifications

Use one existing notification convention per application. New features should use the shared toast/alert component or service rather than inventing module-specific notification systems, session payloads, or transport formats.

Use a small, consistent set of semantic outcomes such as success, information, warning, and error/danger, mapped to the project's UI library. Severity describes the result: a successful deletion is a success, not an error solely because deletion is destructive.

Keep validation feedback associated with the form and its fields. Do not automatically duplicate every field error in a toast. A useful summary may complement field feedback without replacing it.

Centralize message rendering and style mapping. Individual features can supply an appropriate message and outcome without duplicating notification processing across pages.

If a session-based flow is actually involved, avoid collisions with framework-owned flash keys. There is no general ban on a Vue or API field named `status`, and no requirement to add a Laravel Flash class to a client-rendered application.

Use localized user-facing explanations according to the [localization rules](localization.md). Meaningful tests should verify that actual success and failure outcomes produce appropriate feedback; do not impose session-key assertions on a frontend implementation or test trivial styling solely for coverage.
