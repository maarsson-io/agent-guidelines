# Page Toolbar

Use the existing page header or layout for the page title, optional breadcrumbs, and page-level actions. Named slots or suitable component inputs can separate these roles; do not redesign existing pages merely to adopt a slot convention.

Keep page-level actions in a consistent location. Row actions, form submission, and actions belonging to a specific content section may stay with that content rather than being forced into the header.

Reuse controls that repeat across pages or have meaningful complexity. Simple, one-off controls do not require a new abstraction.

Where appropriate, order controls as filters/search/view toggles, create actions, related navigation, context actions such as edit/export/PDF, and destructive actions last. Treat this as a default, not a fixed order overriding the workflow or established UI.

Use the project's UI conventions for button variants and grouping rather than prescribed Bootstrap classes or colors. Make destructive actions clearly recognizable.

The toolbar presents actions and emits events or delegates to the appropriate operation. Keep business work outside the toolbar component. Frontend visibility checks do not replace backend authorization.
