# Data Integrity and Concurrency

Do not rely solely on application-level pre-checks when correctness depends on preventing concurrent conflicting writes.

Where appropriate, consider:

- database constraints
- unique indexes
- transactions
- row locking
- idempotency
- atomic operations

Validation and database integrity mechanisms should complement each other.
