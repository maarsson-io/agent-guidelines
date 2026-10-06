# Review Checks

Use only the sections relevant to the change and its actual risks.

## Business Logic and Reachable States

- Establish the intended business rule from the task and repository. Identify uncertainty rather than inventing a requirement.
- Determine accepted and rejected inputs and states, relevant existing records, boundaries, and state transitions.
- Look for realistically reachable combinations of action ordering, repeated actions, stale or conflicting related data, concurrent execution, navigation, alternate UI paths, and legacy data.
- Identify what actually enforces important invariants. Claims that users will not do something or that a state cannot occur are insufficient unless the system enforces the constraint.
- Check whether partial execution can leave invalid data or state. Focus on meaningful reachable failures rather than enumerating theoretical combinations.

## Regressions

Check effects on existing consumers, not just the new behavior. Search relevant call sites when a method, service, model behavior, or API has multiple consumers.

Inspect changes to contracts, return types, response shapes, defaults, validation, authorization, query and relationship semantics, events, side effects, and frontend expectations. Check whether old data or unchanged callers violate new assumptions.

## Failure Paths and Asynchronous Work

Check what happens when inputs are invalid, expected data is missing or changes, authorization is lost, dependencies fail, or only part of an operation succeeds. Determine whether the resulting state is valid and recoverable.

Assume requests can run concurrently unless the implementation guarantees otherwise. Look for lost updates, non-atomic read-modify-write operations, duplicate processing, and partial writes. Evaluate the invariant before recommending a constraint, transaction, or lock.

Queued work may be delayed, retried, repeated, or executed out of order after related state changes. Check idempotency, stale serialized state or identifiers, and recovery after exceptions or partial processing.

## Other Affected Boundaries

- **Security:** verify server-side authorization and the relevant access paths. Frontend visibility or validation is not an authorization boundary. Support findings with realistic exploitation or failure scenarios.
- **Database:** inspect whether existing data can violate new constraints, defaults, types, identifiers, or relationships. Apply the shared database guidelines for production and rollback risks.
- **Integrations:** assess retry safety, response and delivery ordering assumptions, changing or duplicated external identifiers, and local consistency after failure. A documented API contract does not guarantee every actual response is valid or complete.
- **Frontend:** inspect loading and error states, duplicate submissions, stale asynchronous responses, state synchronization, reactivity, missing data, and navigation or lifecycle effects. Trace backend behavior when important server state is modified.
- **Privacy:** evaluate actual collection, exposure, logging, retention, and third-party transmission. Do not make speculative compliance claims unsupported by the change.
- **Operations:** identify required operational steps and whether rollback needs more than reverting application code.

## Tests

Review tests as critically as production code. Check observable behavior, meaningful failure and boundary coverage, assertion strength, and whether mocks hide relevant behavior. Do not accept tests that merely reproduce implementation logic or would pass despite the defect.

For a bug fix with a regression test, establish that the test would fail before the fix and passes because of it. Apply the shared testing policy when assessing missing tests; do not demand tests for trivial details or changes where they provide no meaningful confidence.
