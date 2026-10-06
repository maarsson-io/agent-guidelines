# Display Values

Show human-readable status labels and appropriately formatted amounts, dates, and states. An understandable visual state indicator is acceptable for booleans; do not require a text label for every flag.

Use shared formatters, translation keys, and reusable display components instead of repeating status mappings or formatting logic on every page. Follow the project's locale, currency, time-zone, and missing-value conventions.

Preserve the underlying API value for application logic, identifiers, sorting, submission, and calculations. Derive the display form without overwriting the source value or changing the contract. Do not assume a legacy amount is in minor units merely because a new backend money design would use them.

Handle a missing or unknown value deliberately rather than presenting it as a valid zero, false state, or known status. Date-only business values and instants may need different formatting semantics.

Raw identifiers, hashes, or payloads may be shown where the surface deliberately provides technical information. An admin page alone is not an exception; distinguish readable labels from explicit machine identifiers.
