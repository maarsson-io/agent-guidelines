# Documentation Locations

Apply `vendor/maarsson/agent-guidelines/resources/guidelines/documentation.md` for applicability, document roles, content, and maintenance.

The locations below are proposed defaults. Confirm or adapt them before writing application documentation. Paths are relative to the consumer root.

| Document type | Location |
| --- | --- |
| Preliminary specification | `docs/specifications/<scope>.md` |
| Post-implementation documentation | `docs/implementation/<scope>.md` |
| Human user manual | `docs/manual/<workflow>.md` |

Use descriptive kebab-case Markdown filenames. Use matching scope names for corresponding specifications and implementation documents. Organize user instructions by workflow.

Create directories when writing the first actual document. Cross-link related documents once they exist, and update relevant existing documentation rather than creating competing versions.
