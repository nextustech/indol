#!/usr/bin/env bash
set -euo pipefail

if [ -z "${APP_KEY:-}" ]; then
  echo "FATAL: APP_KEY is not set. Add APP_KEY to the container environment." >&2
  exit 1
fi

cd /var/www/html

# Prepare writable directories + storage symlink
mkdir -p storage/framework/{cache,sessions,views} storage/logs
chown -R www-data:www-data storage bootstrap/cache
php artisan storage:link >/dev/null 2>&1 || true

# Refresh Laravel caches (guarded: an app can still boot without them)
php artisan optimize:clear >/dev/null 2>&1 || true
php artisan package:discover --ansi >/dev/null 2>&1 || true
php artisan config:cache >/dev/null 2>&1 || true
php artisan view:cache >/dev/null 2>&1 || true

exec "$@"