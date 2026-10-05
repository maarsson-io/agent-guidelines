# Naming

## Shared Domain Vocabulary

Use the same established domain concept across code, models, schema, routes, translation keys, and user-facing terminology. Do not introduce a developer-only synonym for a concept already named by the product.

Consistency is conceptual: a Swedish label and an English identifier may be appropriate translations of the same concept. Distinct domains may have distinct meanings; do not flatten them into one company-wide vocabulary.

Use established names for existing contracts until renaming is an explicit task. Do not mass-rename legacy synonyms as a side effect of adding a feature.

## Express the Role

Prefer verbs for operations and nouns for models, entities, and value objects. Treat this as a clarity guideline, not a grammatical ban: predicates, relationship methods, and Laravel class conventions remain valid.

Prefer specific responsibilities over vague application names ending in `Manager`, `Helper`, `Processor`, or `Handler`. The suffix itself is not forbidden if the complete name conveys a clear role. Preserve intentional framework patterns and required entry-point names.
