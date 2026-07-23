# Local development

## Requirements

- Docker Engine with Docker Compose v2
- Git
- 4 GB of free RAM

## Start the project

```bash
cp .env.example .env
docker compose up -d
```

Open WordPress at `http://localhost:8080` and complete the standard installation wizard.
Adminer is available at `http://localhost:8081` for local database inspection only.

## Activate the theme

In WordPress administration, open **Appearance → Themes** and activate **OnlyHUB**.
Then open **Settings → Permalinks** and save once to register project, partner and campaign routes.

To create the safe demonstration pages, OnlyHUB direction terms and public routes:

```bash
scripts/seed-demo-content.sh
```

The seed command creates `/ecosystem/`, `/support/`, `/reports/`, `/apply/`, `/register/` and the other baseline pages. It does not enable payments or publish invented financial results.

## Stop services

```bash
docker compose down
```

To remove local database and WordPress volumes as well:

```bash
docker compose down -v
```

## Security rules

- Never commit `.env`.
- Replace every example password before using a shared environment.
- Do not expose Adminer publicly.
- Production secrets must be injected by the hosting platform or CI/CD secret store.
- Production deployment must use HTTPS, backups and a web application firewall.

## Current scope

This environment is intended for theme and content-model development. Payment processing, donor records and other sensitive workflows must not use real personal or financial data until the dedicated security and compliance review is complete.
