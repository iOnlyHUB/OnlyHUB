#!/usr/bin/env bash
set -euo pipefail

run_wp() {
  docker compose run --rm wpcli "$@"
}

create_page() {
  local title="$1"
  local slug="$2"
  local content="$3"
  local template="${4:-default}"
  local page_id

  page_id="$(run_wp post list --post_type=page --name="$slug" --field=ID | head -n1)"
  if [ -z "$page_id" ]; then
    page_id="$(run_wp post create --porcelain --post_type=page --post_status=publish --post_title="$title" --post_name="$slug" --post_content="$content")"
  fi

  if [ "$template" != "default" ]; then
    run_wp post meta update "$page_id" _wp_page_template "$template"
  fi
}

create_page "Про OnlyHUB" "about" "OnlyHUB об’єднує благодійні, гуманітарні, культурні та партнерські ініціативи. Замініть цей демонстраційний текст на юридично й редакційно затверджений матеріал."
create_page "Екосистема" "ecosystem" "Foundation, Business, News, Media, Music, Healthcare, Clinical Service, Defence Support, Stop War, Innovation та Production." "page-ecosystem.php"
create_page "Контакти" "contacts" "Додайте офіційні реквізити, адресу, електронну пошту та перевірені канали зв’язку перед публікацією." "page-contact.php"
create_page "Подати заявку" "apply" "Захищена форма для партнерів, волонтерів, донорів і представників медіа." "page-apply.php"
create_page "Особистий кабінет" "dashboard" "Приватна сторінка користувача OnlyHUB." "page-dashboard.php"
create_page "Політика конфіденційності" "privacy-policy" "Чернетка. Перед запуском потрібна юридична перевірка та актуалізація відповідно до законодавства й реальних процесів обробки даних."

PRIVACY_ID="$(run_wp post list --post_type=page --name=privacy-policy --field=ID | head -n1)"
if [ -n "$PRIVACY_ID" ]; then
  run_wp option update wp_page_for_privacy_policy "$PRIVACY_ID"
fi

HOME_ID="$(run_wp post list --post_type=page --name=home --field=ID | head -n1)"
if [ -z "$HOME_ID" ]; then
  HOME_ID="$(run_wp post create --porcelain --post_type=page --post_status=publish --post_title='Головна' --post_name=home)"
fi
run_wp option update show_on_front page
run_wp option update page_on_front "$HOME_ID"

for project in \
  "Humanitarian Support|Пілотна сторінка гуманітарної програми без фінансових показників." \
  "Children and Education|Демонстраційний проєкт підтримки дітей та освіти." \
  "International Partnership|Демонстраційна партнерська програма."; do
  title="${project%%|*}"
  body="${project#*|}"
  slug="$(printf '%s' "$title" | tr '[:upper:]' '[:lower:]' | tr ' ' '-')"
  if ! run_wp post list --post_type=oh_project --name="$slug" --field=ID | grep -q .; then
    run_wp post create --post_type=oh_project --post_status=publish --post_title="$title" --post_name="$slug" --post_content="$body"
  fi
done

echo "Demo content created. Review every public statement before production use."
