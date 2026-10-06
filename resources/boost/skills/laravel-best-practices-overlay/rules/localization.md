# Backend Localization

Use the project's existing Laravel translation resources for backend text intended for users, including validation messages, notifications, emails, and PDFs. Do not create a second localization mechanism or install a package solely to apply this preference.

Prefer meaningful domain-grouped keys and `__()` in new Laravel code. Follow the project's configured language directory, locale, fallback, and established resource format rather than introducing another layout.

Groups such as `listing`, `buttons`, `form`, and `responses` may be useful, but are not a mandatory schema. Choose groups that fit the domain; no fixed count of strings determines when a file or group is required.

Use existing framework validation and authentication translations with targeted overrides rather than duplicating whole groups unnecessarily.

User-authored names, labels, and content are application data, not application translation keys. Multilingual data storage is a separate feature requiring an actual need.

Keep machine-facing codes and diagnostic messages distinct from translated user-facing explanations. For browser-rendered Vue text, apply the [frontend localization rules](../../vue-frontend-best-practices/rules/localization.md).
