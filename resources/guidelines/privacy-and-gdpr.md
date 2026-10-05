# Privacy and GDPR

Treat GDPR and applicable data-protection requirements as first-class requirements whenever personal data is involved.

When working with personal or other sensitive data, apply:

- data minimization
- purpose limitation
- appropriate access control
- secure handling
- minimum necessary retention and exposure

Do not unnecessarily copy, expose, log, export, or retain personal or sensitive data.

Do not assume that database records, logs, or monitoring events are anonymized because they come from a local, development, or staging environment. Unless anonymization is established, handle potentially personal or sensitive data accordingly.

When using database, log, or monitoring tools, including MCP tools, prefer schema information, aggregates, redacted output, or only the fields necessary for the task. Read access does not justify exposing unnecessary personal or sensitive data.

Pay particular attention to privacy implications when modifying:

- logging
- monitoring
- exports
- integrations
- backups
- AI-related functionality
- administrative tools

Do not use real personal production data in tests, fixtures, examples, or debugging output unless explicitly necessary and appropriately handled.
