#!/usr/bin/env bash
set -euo pipefail

run_wp() {
  docker compose run --rm wpcli "$@"
}

create_page() {
  local title="$1"
  local slug="$2"
  local content="$3"

  if ! run_wp post list --post_type=page --name="$slug" --field=ID | grep -q .; then
    run_wp post create --post_type=page --post_status=publish --post_title="$title" --post_name="$slug" --post_content="$content"
  fi
}

create_page "Про OnlyHUB" "about" "OnlyHUB об’єднує благодійні, гуманітарні, культурні та партнерські ініціативи. Замініть цей демонстраційний текст на юридично й редакційно затверджений матеріал."
create_page "Екосистема" "ecosystem" "Foundation, Business, News, Media, Music, Healthcare, Clinical Service, Defence Support, Stop War, Innovation та Production."
create_page "Контакти" "contacts" "Додайте офіційні реквізити, адресу, електронну пошту та перевірені канали зв’язку перед публікацією."
create_page "Політика конфіденційності" "privacy-policy" "Чернетка. Перед запуском потрібна юридична перевірка та актуалізація відповідно до законодавства й реальних процесів обробки даних."

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
  if ! run_wp post list --post_type=project --name="$slug" --field=ID | grep -q .; then
    run_wp post create --post_type=project --post_status=publish --post_title="$title" --post_name="$slug" --post_content="$body"
  fi
done

echo "Demo content created. Review every public statement before production use."
