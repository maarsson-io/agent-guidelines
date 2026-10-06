# Frontend Development

- Frontend validation may improve user experience but must not replace server-side validation or authorization.
- Before modifying authentication, cookies, CSRF handling, request interceptors, credentials, or API base configuration, inspect the existing HTTP client configuration and related security behavior.
- Introduce frontend dependencies only when a clear benefit justifies the additional maintenance cost.

## Recommendations for New JavaScript and TypeScript Code

- In TypeScript code, prefer descriptive named types or interfaces over complex inline type definitions when this improves readability.
