# Code Quality

Use English for code, identifiers, and code comments.

When adding or changing code comments, apply the shared comment guidelines in [development principles](development-principles.md).

Follow the project's configured formatting and code-quality rules.

Where legacy failures are known, run the relevant checks on the affected code before editing and retain the findings for comparison after the change.

After every change, run the configured code-quality checks applicable to the affected code using the project's configured commands and scope. This includes PHPCS, PHP-CS-Fixer, PHPMD, PHPStan/Larastan, ESLint, and any other configured checks.

Checks that passed before the change must continue to pass. Where a check already reports legacy failures, the change must not introduce new failures. Compare findings before and after the change under the same configuration and relevant scope; an unchanged total error count alone does not prove that no new failures were introduced.

Report pre-existing failures separately. Do not expand the task into unrelated fixes or refactoring merely to make a legacy check pass. Pre-existing failures alone do not make an otherwise verified change incomplete.

If new and pre-existing failures cannot be distinguished reliably, report that verification limit rather than claiming that the check passed or that no new failures were introduced.

Do not suppress, disable, or weaken an existing code-quality rule merely to make a change pass. If a rule appears inappropriate or conflicts with the requested implementation, identify the conflict explicitly rather than bypassing it.
