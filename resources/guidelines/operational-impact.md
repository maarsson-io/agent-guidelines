# Operational and Deployment Impact

Consider operational consequences when changes affect deployment, configuration, queues, scheduled tasks, storage, external integrations, or other production infrastructure.

Clearly identify changes before deployment that may:

- cause downtime
- require configuration changes or environment variables
- require queue worker restarts
- require cache clearing
- affect scheduled jobs
- affect storage or external services
- invalidate credentials
- require coordinated deployment steps

When the project has a staging environment, meaningful changes should normally be validated there before production deployment. Follow the project's actual environments and deployment rules.

When rollback is relevant, distinguish between:

- reverting application code
- reverting configuration
- reverting schema
- recovering data

These are not necessarily equivalent operations. For schema changes and data recovery, apply the [database change guidelines](database-changes.md).
