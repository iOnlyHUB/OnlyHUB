#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

if ! command -v docker >/dev/null 2>&1; then
  echo "Docker is required." >&2
  exit 1
fi

if [ ! -f .env ]; then
  cp .env.example .env
  echo "Created .env from .env.example. Review credentials before production use."
fi

docker compose up -d db wordpress

echo "Waiting for WordPress..."
for _ in $(seq 1 60); do
  if curl -fsS http://localhost:8080/wp-admin/install.php >/dev/null 2>&1; then
    break
  fi
  sleep 2
done

docker compose run --rm wpcli core install \
  --url="http://localhost:8080" \
  --title="OnlyHUB" \
  --admin_user="${WP_ADMIN_USER:-onlyhub_admin}" \
  --admin_password="${WP_ADMIN_PASSWORD:-ChangeMe-Local-Only-123!}" \
  --admin_email="${WP_ADMIN_EMAIL:-admin@example.test}" \
  --skip-email || true

docker compose run --rm wpcli theme activate onlyhub

docker compose run --rm wpcli rewrite structure '/%postname%/' --hard

docker compose run --rm wpcli option update blogdescription 'International Charity Foundation'

echo "OnlyHUB is available at http://localhost:8080"
