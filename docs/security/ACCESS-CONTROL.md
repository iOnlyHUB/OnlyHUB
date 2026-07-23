# OnlyHUB access control

## Purpose

This document defines the first application-level role model for the OnlyHUB WordPress platform. It does not replace hosting, identity-provider or legal security controls.

## Roles

- `onlyhub_donor` — authenticated donor with read-only frontend access.
- `onlyhub_volunteer` — volunteer account with profile access and limited upload capability.
- `onlyhub_partner` — partner account with profile access and limited upload capability.
- `onlyhub_coordinator` — operational role allowed to edit platform content assigned through WordPress capabilities.
- WordPress administrators retain full administrative control.

## Default behaviour

Non-editor members are redirected away from `/wp-admin/` to `/dashboard/`. The WordPress admin toolbar is hidden for those users. After login, non-editor users are redirected to the member dashboard. Logout returns to the homepage.

## Production requirements

Before public registration is enabled:

1. Confirm which roles may self-register and which require invitation.
2. Add verified-email enforcement.
3. Add rate limiting and bot protection to registration and login.
4. Require multifactor authentication for administrators and coordinators.
5. Review upload permissions and allowed MIME types.
6. Establish account suspension, deletion and data-export procedures.
7. Add an auditable approval process for elevated roles.
8. Test privilege escalation, direct admin URL access and password-reset flows.

## Safety decision

Public self-registration is intentionally not enabled by this change. Accounts must be created or approved by an authorised administrator until identity verification and abuse controls are implemented.
