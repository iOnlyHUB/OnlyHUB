#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${BASE_URL:-http://localhost:8080}"

assert_status() {
  local path="$1"
  local expected="$2"
  local actual
  actual="$(curl -sS -o /tmp/onlyhub-smoke-body -w '%{http_code}' "${BASE_URL}${path}")"
  if [ "$actual" != "$expected" ]; then
    echo "FAIL ${path}: expected ${expected}, got ${actual}" >&2
    cat /tmp/onlyhub-smoke-body >&2 || true
    exit 1
  fi
  echo "PASS ${path} -> ${actual}"
}

assert_contains() {
  local path="$1"
  local needle="$2"
  if ! curl -fsS "${BASE_URL}${path}" | grep -Fqi "$needle"; then
    echo "FAIL ${path}: missing text '${needle}'" >&2
    exit 1
  fi
  echo "PASS ${path} contains '${needle}'"
}

assert_status "/" "200"
assert_status "/wp-login.php" "200"
assert_status "/wp-json/" "200"
assert_status "/projects/" "200"
assert_status "/campaigns/" "200"
assert_status "/partners/" "200"
assert_status "/ecosystem/" "200"
assert_status "/support/" "200"
assert_status "/reports/" "200"
assert_contains "/" "OnlyHUB"
assert_contains "/ecosystem/" "OnlyHUB Foundation"
assert_contains "/support/" "Donation safety"
assert_contains "/reports/" "Transparency"

if curl -fsS "${BASE_URL}/?s=onlyhub" | grep -Eqi 'Fatal error|Parse error|Warning:'; then
  echo "FAIL: PHP error exposed in response" >&2
  exit 1
fi

echo "OnlyHUB smoke tests passed."
