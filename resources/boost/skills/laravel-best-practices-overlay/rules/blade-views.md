# Blade Presentation

Apply this file only to actual Blade templates, including PDF and email templates. It is not the frontend implementation guide for a Vue application.

Prepare data outside the template. Do not put queries, data mutations, business-rule decisions, or substantial collection processing into Blade or hide such work inside presentation accessors.

Simple presentation conditions, loops, property access, translation and URL helpers, formatting calls, and PHPDoc type hints are appropriate. Separate business decisions from the conditions needed to render an already established state.

Choose the preparation mechanism according to the actual responsibility: Services or Actions for business work, a model operation for relevant model behavior, and a presenter, accessor, or view model for display values. Keep controllers thin under the maintained backend guideline.

Use a view composer when shared partial data genuinely benefits from it; explicit component or view inputs are equally valid where simpler. Do not introduce a composer or presenter for every trivial value.

Use the [display-value](display-values.md) and [localization](localization.md) rules for human-readable output. Put operational commands in developer or operations documentation rather than in user-facing product explanations.
