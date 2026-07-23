# OnlyHUB application workflow

## Purpose

Applications from partners, volunteers, donors and media contacts are stored as private WordPress records. They are not exposed through public search, feeds or REST endpoints.

## Workflow statuses

- `new` — received and not yet reviewed;
- `in_review` — assigned for validation or follow-up;
- `approved` — accepted for the next operational step;
- `rejected` — declined with the decision documented outside public content;
- `archived` — closed and retained according to the approved retention policy.

## Required moderation process

1. Confirm that the application contains sufficient information.
2. Verify contact details using an approved communication channel.
3. Change the workflow status to `in_review`.
4. Record supporting notes only in systems approved for personal data.
5. Change the status to `approved`, `rejected` or `archived`.
6. Never copy sensitive personal information into public posts or issue trackers.

## CSV export

Editors and administrators can export all private applications from the Applications list screen. The export contains names, email addresses, application types, statuses and submitted messages.

CSV files contain personal data and must therefore:

- be stored only in approved encrypted storage;
- never be committed to Git;
- never be sent through public messengers;
- be deleted after the approved operational need ends;
- be accessible only to authorized staff.

## Audit log

Every application status change creates an immutable private audit event containing:

- the application ID;
- the previous status;
- the new status;
- the acting WordPress user;
- a timestamp;
- a salted hash of the request IP address.

The log intentionally excludes passwords, secrets, tokens and raw IP addresses.

## Production requirements

Before public launch, define and approve:

- the application retention period;
- the responsible data controller;
- authorized staff roles;
- incident-response contacts;
- lawful basis and privacy notice wording;
- the secure location for exported reports.
