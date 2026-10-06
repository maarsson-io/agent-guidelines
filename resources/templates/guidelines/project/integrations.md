# Integration Contracts and Skills

Apply `vendor/maarsson/agent-guidelines/resources/guidelines/external-integrations.md` and the shared testing policy.

- HTTP integration client: [Installed client and version, such as Saloon where used.]
- Implementation conventions: [Actual connector/request layout and reusable components.]

| Integration | Contract or documentation | Activate local skill |
| --- | --- | --- |
| [Service] | [OpenAPI URL or documentation location] | [Adapted skill name] |

Keep detailed API contracts and integration-specific rules in the corresponding domain skills. Their maintained sources belong in `.ai/skills/<skill-name>/`; Boost installs them alongside package skills.

## Test Isolation

- Client-specific stray-request guards: [Actual protections for every transport.]
- Missing-fixture behavior: [How tests fail without contacting real services.]

Do not assume Laravel HTTP fakes protect independent clients or direct network access. Verify the project's actual protections before running integration tests.
