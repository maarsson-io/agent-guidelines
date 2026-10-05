# Findings and Output

## Evidence and False Positives

Report confirmed defects supported by a realistic execution path and meaningful consequence. Distinguish verified facts, evidence-based conclusions, and unresolved assumptions. An unverified assumption belongs in questions or uncertainties, not in confirmed findings.

Do not report personal style preferences, intentional behavior established by the task, safely handled framework behavior, speculative performance concerns, optional refactoring, or missing abstractions without a concrete defect. No findings is preferable to invented or weak findings.

Review how responsibilities are assigned, not whether a class type appears in a guideline's non-exhaustive list. An omitted layer is not implicitly prohibited, and a Boost example's method name does not override an established Action entry-point convention such as `__invoke()`.

Prioritize practical impact: data loss or corruption, security and access control, incorrect business behavior, concurrency, service disruption, privacy, regressions, migrations, integrations, and test gaps that hide meaningful risk. Maintainability findings must identify concrete future risk.

## Severity

| Severity | Practical impact |
| --- | --- |
| Critical | Major data loss or corruption, serious security compromise, broad unauthorized access, major privacy breach, or production-wide outage. Use rarely and with strong evidence. |
| High | Incorrect important business data, unauthorized access, significant production failure, duplicate or lost financial/operational effects, or serious migration/deployment failure. |
| Medium | Meaningful but limited impact: a reachable edge-case defect, localized regression, recoverable consistency issue, missing failure handling, or a test gap hiding a plausible regression. |
| Low | A concrete defect with limited operational impact. Not a category for preferences or optional cleanup. |

## Corrections

Suggest the smallest practical correction that reliably addresses each confirmed defect and follows maintained project rules. Keep it compatible with the actual architecture and stack. Avoid broad refactoring or extra complexity unless necessary to resolve the demonstrated problem safely. Do not apply the correction during review.

## Report

Put actionable findings first, ordered by severity. For each finding provide:

- severity, concise title, and file/location
- the defect and supporting evidence
- a realistic trigger and consequence
- the suggested correction

Include these sections only when relevant:

- **Questions / Unverified assumptions:** unresolved uncertainties materially affecting correctness.
- **Test gaps:** missing coverage that leaves meaningful behavior or a finding insufficiently protected.
- **Operational considerations:** required deployment, configuration, queue, migration, or rollback steps.
- **Incidental legacy defects:** verified defects outside the change, separately identified and excluded from the change's finding count.

Finish with a concise summary of confirmed finding counts and severities, merge assessment, and important unresolved assumptions or verification limits.

Use the following assessments when supported by the review evidence:

| Assessment | Meaning |
| --- | --- |
| Safe to merge | No meaningful defects or unresolved blocking risks were identified. |
| Safe to merge with minor follow-up | Only non-blocking issues remain. |
| Changes requested | One or more issues should be resolved before merge. |
| Do not merge | A Critical or otherwise unacceptable production risk remains. |

Do not certify safety merely because no syntax or style problems were found. If material uncertainty or incomplete review prevents a supported merge assessment, state that limitation explicitly. Do not block a merge for optional improvements without a meaningful defect.
