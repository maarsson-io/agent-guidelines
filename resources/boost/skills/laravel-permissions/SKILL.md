---
name: laravel-permissions
description: Design and implement permission-based access control in Laravel applications using spatie/laravel-permission, Laravel Policies, FormRequest authorization, Eloquent visibility scopes, thin controllers, and frontend abilities. Use when adding or changing roles, permissions, resource access, record visibility, permission-aware forms, or authorization-related UI.
license: MIT
---

# Laravel Permissions

Use Laravel's native authorization mechanisms for application authorization and `spatie/laravel-permission` for storing, assigning, and resolving roles and permissions.

## Applicability

This skill is mandatory whenever the task adds or changes roles, permissions, or authorization, including in projects whose existing authorization follows a different pattern.

Apply it to the code the task adds or changes. Do not rewrite untouched authorization code solely to make it conform.

Changing the authorization mechanism must not change who can do what as a side effect. Change effective access only when explicitly requested.

If `spatie/laravel-permission` is not installed, do not install it without approval: stop and ask before implementing.

## Reading this skill

This skill describes principles, not code to copy. Follow the project's conventions for class names, file locations, helper names, and response shapes.

The names used for illustration are placeholders:

- `absences` stands for any resource bound to a model.
- `own`, `department`, and `all` stand for a scope ladder: narrowest, any number of domain-specific intermediate levels, broadest. A resource may have no intermediate level, or a different one.

## Core principles

- Permissions represent business capabilities, not routes.
- Roles are permission groups only. A user may receive permissions through roles and/or direct assignments, and the application must behave identically either way.
- Application authorization must check permissions, never role names: not in Policies, FormRequests, model scopes, or frontend logic. Role names may be used only when administering roles themselves and in the super-admin rule described under "Package usage".
- Use Laravel's `$user->can()` and `$user->canAny()` for runtime authorization, not Spatie's `hasRole()` or `hasPermissionTo()`.
- Use Spatie APIs for assigning and synchronizing roles and permissions, not as a replacement for Laravel Policies and Gates.
- Backend authorization is always authoritative. Frontend ability checks only control UX and are never a security boundary.
- Authorization logic must fail closed when no matching permission exists.
- Prefer Laravel-native Policies, Gates, FormRequests, and Eloquent scopes over custom authorization abstractions unless the domain requires something more specialized.

## Package usage

- **Guard:** use one guard name for all roles and permissions, and make it the guard the user model resolves to. Do not create permissions under different guards.
- **Cache:** change roles, permissions, and their assignments only through the package's models and methods, which reset its permission cache. If a direct database write is unavoidable, reset the cache explicitly afterwards.
- **Super-admin:** if the project has a role that may do everything, grant it in a single `Gate::before` callback as the package documents. This is the only place where application logic may check a role name, and it only takes effect for checks made through `can()`.

## Permission naming

Name permissions `resource.action[-scope]`, for example `absences.update` or `absences.update-own`.

- Use Laravel's Policy ability names for the action of a model-bound resource: `view`, `create`, `update`, `delete`, and `restore` or `force-delete` where they apply. Listing is covered by `view`; do not introduce a separate listing action.
- Use a business-specific action for capabilities that are not CRUD.
- Add a scope suffix only when the same action is granted at different scopes.

Do not mechanically create one permission per route. A permission may authorize several endpoints, and an endpoint may accept any of several permissions.

Do not create a generic permission when scoped permissions fully express the capability. If `create-own` and `create-all` cover creation, do not also add `create` unless it has a separate business meaning.

## Permission catalog

Define every permission name in a config file. That file is the only source of permission names; never create permissions at runtime or through a user interface. The same file defines the default role assignments.

An idempotent seeder, run on every deployment, synchronizes the database with the catalog through the package's API:

- it creates permissions that are defined but missing;
- it deletes permissions that are no longer defined, together with all their role and direct assignments;
- it applies role assignments according to the project's assignment model.

A project uses one of two assignment models:

- **Fixed:** the catalog is authoritative. The seeder makes each role's permissions match it on every run.
- **Dynamic:** administrators own the assignments. The seeder assigns the catalog's defaults only to permissions it creates in that run and never changes existing assignments.

Determine which model the project uses before changing the catalog or the seeder; if it cannot be determined, ask. Use the dynamic model for a new project unless told otherwise.

When adding a permission, add its default roles to the catalog and state them when reporting the change.

## Resource authorization pattern

For a typical API resource, use the following responsibility split:

| Controller action | Authorization |
| --- | --- |
| `index()` | Policy `viewAny()` for general access + model scope for record visibility |
| `store()` | Policy `create()` for general access + Store FormRequest `authorize()` for the request-dependent decision |
| `show()` | Policy `view()` |
| `update()` | Update FormRequest `authorize()`, delegating the record-level decision to Policy `update()` |
| `destroy()` | Policy `delete()` |

A permission answers what capability the user has. The Policy answers whether that capability allows this operation on this concrete model.

### Index

Listing has two separate authorization questions:

1. May this user access this type of resource at all?
2. Which records may this user see?

Answer the first in Policy `viewAny()`: allow when the user holds the view permission at any scope. Do not make `viewAny()` responsible for filtering records.

Answer the second in an Eloquent visibility scope on the model that takes the user:

- Check scopes from broadest to narrowest and apply the first one the user holds.
- Check every scope's permission explicitly, including the narrowest. Never fall through to "own records" as a default.
- Return no records when the user holds none of the permissions. Do not assume `viewAny()` was called first; the scope may later be used from somewhere that did not call it.

Never load unscoped records after a broad `viewAny()` check when record visibility is scoped.

### Store

Creation has the same two questions as listing:

1. May this user create this type of resource at all?
2. May this user create this particular record?

Answer the first in Policy `create()`: allow when the user holds the create permission at any scope. The Policy has no access to request data, so it must not try to answer the second.

Answer the second in a dedicated Store FormRequest whose `authorize()` first delegates to Policy `create()` and then applies the request-dependent constraint, such as who the new record will belong to:

- With the broadest create permission, the client may choose the target user; the backend still validates that the target exists.
- With the own-scope create permission, the backend must verify that the submitted owner equals the authenticated user. Never trust a client-provided owner ID because the frontend supplied it as a hidden field.

### Show, update, and delete

Decide access to a concrete route-bound model in the Policy: allow when the user holds the action's permission at a scope whose condition the model satisfies.

A scope condition must compare actual values. It must never be satisfied because the compared attribute is missing on both sides, such as a user and a record owner who both have no department.

For update, use a dedicated Update FormRequest whose `authorize()` delegates to Policy `update()`. Do not duplicate the record-level decision in the FormRequest. If authorization additionally depends on submitted data, apply that request-specific constraint in the FormRequest after the Policy check.

### Ownership changes

Do not accept ownership fields such as `user_id` in an ordinary update request unless changing ownership is an intentional business capability.

If reassignment is required, model it explicitly with its own permission and authorization rule instead of allowing it through normal update validation.

### Shared validation rules

Splitting a request into Store and Update should not duplicate validation rules. Sharing them, for example through a trait, is an organizational recommendation, not an authorization requirement; follow the project's conventions for where and how.

Keep authorization in the concrete FormRequests, never in the shared rules.

## Thin controllers

Controllers should contain only route-invokable actions where practical. Do not add private authorization or visibility helper methods to a controller; that responsibility belongs in the Policy, the FormRequest, or the model scope.

Invoke Policies through the project's established controller authorization convention.

## Frontend abilities

The frontend may receive the authenticated user's effective permission names to control UX.

- Expose only the authenticated user's effective permissions: those inherited through roles and those assigned directly, without distinguishing them.
- Do not expose the complete permission catalog or role names merely to perform UI checks.

Frontend behavior may legitimately differ by ability. A form may show a user selector to someone who can create for anyone, and silently target the authenticated user for someone who can only create their own.

## Special business actions

Not every permission belongs to CRUD. Use business-specific permissions for capabilities such as sending a document, converting one record into another, or triggering a manual synchronization, instead of forcing them into `view/create/update/delete` semantics.

- For operations on a concrete model, decide in a Policy.
- For operations without a model, use a Gate or a direct permission check.

## Security rules

Authorization must always be enforced on the backend. The authenticated backend user and server-side permission state are authoritative.

Never rely on:

- hidden, disabled, or omitted frontend fields and controls;
- hidden buttons, routes, or menu items;
- frontend route guards;
- role or permission names sent by the client.

When a permission grants scoped access, enforce both the capability and the scope condition. Holding `update-own` is not enough without the record belonging to the user, and owning the record is not enough without the permission.

## Testing requirements

Authorization changes must include focused tests for the relevant boundaries. For a scoped resource, test at least:

- **Index:** each scope sees exactly the records inside it and none outside it; a user with no view permission cannot access the endpoint.
- **Store:** own-scope with own ID is allowed; own-scope with another user's ID is forbidden; broadest scope with another valid user's ID is allowed; no create permission is forbidden.
- **Show, update, delete:** for each scope, a record inside the scope is allowed and a record outside it is forbidden; the broadest scope is allowed.
- **Update:** the ownership field cannot be modified unless explicitly supported.

Grant permissions directly to the test user instead of assigning a role, so tests do not depend on which permissions a role currently holds.

Where direct permissions are supported, verify that a directly assigned permission behaves the same as one inherited through a role.

## Implementation workflow

When adding or changing permission-controlled functionality:

1. Identify the business capability.
2. Determine whether the action is scoped.
3. Define the minimum required permissions.
4. Add the permissions and their default role assignments to the permission catalog.
5. Implement general resource access and record-level decisions in the Policy.
6. Implement collection visibility in a model scope.
7. Implement request-context authorization in Store and Update FormRequests.
8. Expose effective abilities to the frontend only when required for UX.
9. Add tests for allowed access, denied access, and scope boundaries.
10. Update related documentation.
