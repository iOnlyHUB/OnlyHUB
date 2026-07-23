# OnlyHUB payment integration gate

Payment processing is intentionally disabled in the repository until the organisation, campaign and provider accounts are verified.

## Mandatory prerequisites

1. Confirm the legal entity name, registration number and authorised representatives.
2. Approve the public offer, privacy policy, refund policy and donation terms.
3. Complete provider KYC/KYB and obtain sandbox credentials.
4. Confirm settlement currencies and bank accounts.
5. Configure HTTPS, secure secret storage and webhook signature verification.
6. Complete campaign-level legal and financial verification.
7. Pass sandbox payment, refund, duplicate webhook and failure-path tests.
8. Obtain written production approval from the authorised OnlyHUB representative.

## Architecture rules

- Never store card details in WordPress.
- Redirect to a hosted checkout or use provider-controlled payment components.
- Keep API secrets outside Git and outside the WordPress database where possible.
- Verify every webhook signature before changing donation status.
- Make webhook processing idempotent using the provider event ID.
- Store the minimum necessary donor data.
- Separate provider transaction IDs from public references.
- Record refunds and chargebacks as immutable financial events.
- Do not calculate public totals from unverified or pending transactions.

## Campaign enablement rule

A donation button may be rendered only when all of the following are true:

- `_oh_verified` is true;
- the campaign status is explicitly active;
- a supported currency is configured;
- the provider is enabled in the deployment environment;
- the campaign has not passed its end date;
- production approval has been recorded.

## Initial provider order

1. Ukrainian provider selected by the legal entity.
2. Stripe or PayPal for supported international settlements.
3. Apple Pay and Google Pay through the selected provider, not as independent integrations.
4. Cryptocurrency only after separate legal, accounting and sanctions review.

## Required tests

- successful payment;
- declined payment;
- cancelled checkout;
- duplicate webhook delivery;
- invalid webhook signature;
- delayed webhook;
- partial and full refund;
- currency mismatch;
- inactive or unverified campaign;
- donation total reconciliation.

No real credentials, card data or production endpoints belong in this repository.
