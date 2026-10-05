# Backend Development

The Service and Action guidance below describes preferred responsibilities, not an exhaustive list of permitted class types. Other suitable project layers, such as Repositories, Getters, Data/DTO classes, and Policies, remain valid; their absence from this list does not prohibit their use.

- Use dedicated Form Request classes for HTTP request validation.
- Use Laravel transactions and appropriate locking where required for data consistency or safe concurrent execution.
- Use Laravel queues and jobs for work suited to background execution.
- Keep controllers very thin: handle HTTP input, delegate work, and construct the response. Keep business logic out of controllers.
- Place complex business logic in Service classes.
- Extract well-defined, reusable operations into Action classes.
- Keep Services and Actions independent of HTTP: accept explicit input data and return business results. Keep HTTP Request and Response handling in controllers so these operations can also be used from jobs and Artisan commands.

For data writes and concurrent operations, apply the [data integrity and concurrency guidelines](data-integrity-and-concurrency.md).
