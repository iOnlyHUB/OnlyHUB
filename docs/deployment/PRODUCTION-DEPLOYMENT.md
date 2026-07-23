# OnlyHUB Production Deployment Runbook

This document describes the minimum safe release process for `only-hub.org`.

## Release gates

A production release must not proceed until all of the following are true:

- pull request checks pass;
- approved logos and imagery are present and optimized;
- content owners verify all public text and statistics;
- legal pages and donation disclosures are approved;
- payment integration is tested in provider sandbox mode;
- a full database and uploads backup has been created and restored in staging;
- HTTPS, security headers, monitoring and alerting are enabled;
- administrator accounts use unique passwords and multi-factor authentication.

## Recommended architecture

- managed Linux hosting or VPS;
- Nginx or Apache behind HTTPS;
- supported PHP 8.x release;
- MariaDB or MySQL with private network access;
- object/page cache approved for WordPress;
- off-site encrypted backups;
- staging environment separate from production.

## Deployment sequence

1. Create a tagged release from reviewed `main`.
2. Back up the production database and `wp-content/uploads`.
3. Put the site into maintenance mode.
4. Deploy only version-controlled theme and MU-plugin files.
5. Run database migrations only when documented and reversible.
6. Clear application and CDN caches.
7. Verify homepage, navigation, project archive, project details, contact route, login and REST endpoints.
8. Disable maintenance mode.
9. Monitor PHP errors, HTTP 5xx responses, uptime and form delivery for at least 30 minutes.

## Rollback

1. Re-enable maintenance mode.
2. Restore the previous tagged release.
3. Restore the database only if the release changed data structures or corrupted content.
4. Clear caches.
5. Repeat smoke tests.
6. Record the incident and root cause before attempting another release.

## Secrets

Never commit production passwords, API keys, payment credentials, SMTP credentials, private certificates or WordPress salts. Store them in the hosting secret manager or protected environment configuration.

## Payments

No payment provider should be activated until OnlyHUB has verified legal entity details, beneficiary accounts, refund policy, privacy notice, sanctions screening requirements and provider webhook signatures.
