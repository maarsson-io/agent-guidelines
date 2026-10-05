# PHP-Rendered Display Values

For PDFs, emails, and other PHP-rendered user-facing output, show understandable labels and appropriately formatted amounts, dates, and states rather than unprocessed storage values.

Use a shared formatter, enum label, presenter, accessor, or other suitable existing display mechanism instead of repeating mappings in templates. An understandable visual boolean indicator may be appropriate; every flag does not require a text label.

Keep the underlying machine value and display representation distinct. Formatting for a person must not silently alter a persisted value, business calculation, or existing API contract.

Use the project's intended locale, currency, and time-zone semantics. Do not infer a money unit from the field's numeric type or apply a time-zone conversion to a date-only value without a domain reason.

Raw values are appropriate for deliberately technical surfaces or explicit machine identifiers. An admin screen alone is not a blanket exception.

Use the [Vue display-value rules](../../vue-frontend-best-practices/rules/display-values.md) for client-rendered output.
