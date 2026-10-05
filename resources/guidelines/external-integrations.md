# External Integrations

Treat external integrations as failure-prone boundaries.

When modifying an integration, consider:

- authentication and authorization
- timeouts, retries, rate limits, and external service downtime
- idempotency and duplicate delivery or execution
- partial failures
- malformed or unexpected responses
- backwards compatibility

Do not assume external systems will always return valid, complete, or unique data.

For idempotency and duplicate execution, apply the [data integrity and concurrency guidelines](data-integrity-and-concurrency.md).

When personal or sensitive data is involved, including integration logging, apply the [privacy and GDPR guidelines](privacy-and-gdpr.md).
