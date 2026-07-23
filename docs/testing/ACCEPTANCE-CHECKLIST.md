# OnlyHUB acceptance checklist

Use this checklist before merging or deploying any release.

## Installation

- [ ] `docker compose config` succeeds.
- [ ] Fresh installation completes with `scripts/install-local.sh`.
- [ ] OnlyHUB theme activates without PHP notices or fatal errors.
- [ ] Permalinks are enabled and project URLs resolve.
- [ ] Theme ZIP installs through WordPress Admin.

## Content and branding

- [ ] Approved primary logo is present in SVG and PNG.
- [ ] All approved ecosystem logos are present and correctly named.
- [ ] Homepage hero has desktop, tablet and mobile WebP variants.
- [ ] No placeholder statistics, invented partners or unverified claims are public.
- [ ] Ukrainian copy has been editorially reviewed.

## Functional checks

- [ ] Homepage, project, campaign and partner archives return HTTP 200.
- [ ] Ecosystem, Support and Transparency Centre pages return HTTP 200.
- [ ] Every public template exposes the `#main-content` keyboard skip-link target.
- [ ] Navigation works with keyboard only.
- [ ] Search and 404 pages work.
- [ ] Contact form uses server-side validation, nonce protection and anti-spam controls.
- [ ] Emails are delivered through an authenticated SMTP provider.
- [ ] Donation buttons point only to approved payment pages.
- [ ] Unverified campaigns and report links are excluded from Support and Transparency Centre pages.

## Security

- [ ] Production secrets are absent from Git and stored in the host secret manager.
- [ ] HTTPS is forced and HSTS is enabled after certificate validation.
- [ ] XML-RPC remains disabled unless a documented integration requires it.
- [ ] Administrator accounts use unique passwords and MFA.
- [ ] File editing from WordPress Admin is disabled.
- [ ] Backups are encrypted and a restore test has succeeded.
- [ ] WordPress core, theme and plugins are fully patched.

## Privacy and legal

- [ ] Legal entity name and registration details are verified.
- [ ] Privacy policy reflects actual data processing.
- [ ] Terms, donation conditions and refund process are approved.
- [ ] Cookie/analytics consent is configured where required.
- [ ] Retention periods and data deletion workflow are documented.

## Quality

- [ ] GitHub Actions checks pass.
- [ ] `scripts/smoke-test.sh` passes against staging.
- [ ] Mobile layouts are checked at 320, 375, 768 and 1440 px.
- [ ] Images have descriptive alt text or are correctly marked decorative.
- [ ] Lighthouse and accessibility findings have no unresolved critical issues.
- [ ] Rollback procedure and release owner are confirmed.
