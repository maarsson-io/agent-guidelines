# Component Design

Keep templates focused on rendering prepared state and expressing presentation conditions. Do not put substantial business operations or data reshaping into template expressions.

Use appropriate computed values, methods, existing client operations, or dedicated shared modules to prepare data. Choose according to the responsibility rather than prescribing one abstraction for every component.

Reuse existing components and suitable shared helpers when they solve the task. Extract repeated or substantial presentation behavior where it creates a concrete benefit; a one-off button or trivial expression does not need a new component hierarchy.

Use explicit component inputs and events where that keeps responsibilities clear. Share data preparation when genuinely needed, without inventing a new state-management layer or parallel API client.

Frontend conditions and validation support usability; they never replace backend authorization or validation. Apply the maintained frontend-development rules (`vendor/maarsson/agent-guidelines/resources/guidelines/frontend-development.md`) when changing security-related HTTP behavior.

Explain product states and outcomes in plain language. Keep Artisan and shell instructions in developer or operations documentation rather than in user-facing empty states, alerts, or help text.
