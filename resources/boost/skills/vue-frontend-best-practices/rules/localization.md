# Localization

Use the project's existing frontend translation resources and localization integration for user-facing text. Do not impose Laravel PHP language files on Vue or install another localization package just to follow this rule.

Prefer meaningful domain-grouped keys and consistent terminology. Keep the configured locale, fallback, and resource format. Avoid introducing an arbitrary mixture of text-as-key, domain-key, and hard-coded conventions.

Group names such as listing, buttons, form, and responses are examples, not a required schema. Adapt the layout to the actual project and domain; do not decide resource structure using a fixed count of strings.

User-authored names, labels, and content remain application data. Do not turn them into application translation keys or introduce multilingual persistence without an actual feature requirement.

Reuse existing validation and authentication translations where suitable. Backend-generated validation, email, and PDF text uses the backend's localization resources; it need not share the frontend's file format.

Keep machine codes and payload values distinct from translated labels. Localization affects human-readable display, not API identifiers or business contracts.
