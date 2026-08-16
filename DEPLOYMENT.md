# Docker / Dokploy Deployment Guide

Dockerized setup for **Indolia (Rx Physio)** — Laravel 10 PHP 8.2 + MySQL 8.0.

## Architecture

Containerized in **Docker Compose** (3 services):

| Service | Image | Role |
|---|---|---|
| `app` | built from `Dockerfile` | nginx + PHP-FPM (supervisord), port `80` |
| `queue` | same image | `php artisan queue:work` (database queue used by SMS) |
| `db` | built from `docker/Dockerfile.db` | MySQL 8.0, loads the DB snapshot on first boot |

### Note on database schema

The Laravel app is backed by a ~55-table schema, but the `database/migrations/`
folder only tracks the most recent tables. **The schema + existing data ship as a
SQL snapshot** at `database/dumps/indolia_full.sql` and are imported automatically
when the `db` volume is first created (MySQL `docker-entrypoint-initdb.d`).

- To refresh the snapshot from your current DB:
  ```bash
  mysqldump -h 127.0.0.1 -P 3306 -u root -p --single-transaction --routines \
    --triggers --default-character-set=utf8mb4 --no-create-db indolia \
    > database/dumps/indolia_full.sql
  ```
- Snapshot is re-imported **only** when `db_data` volume does not exist yet
  (e.g. delete the volume to rebuild a fresh DB).

## Deploying on Dokploy

1. **Push this repository** (including `Dockerfile`, `docker-compose.yml`,
   `docker/`, and `database/dumps/indolia_full.sql`) to your Git provider.

2. In Dokploy create a **"Compose"** (or Docker Compose) project pointing at the
   repo, using `docker-compose.yml`.

3. Set these environment variables in the project **Environment** tab:

   | Variable | Example | Required |
   |---|---|---|
   | `APP_KEY` | `base64:...` (copy from your `.env`) | ✅ |
   | `APP_URL` | `https://indolia.de` | ✅ |
   | `DB_DATABASE` | `indolia` | ✅ |
   | `DB_USERNAME` | `indolia` | ✅ |
   | `DB_PASSWORD` | `<secret>` | ✅ |
   | `DB_ROOT_PASSWORD` | `<secret>` | ✅ (only used by db service) |
   | `APP_PORT` | `8080` (host port for `app`) | optional |
   | `MAIL_*` | real SMTP credentials | optional |

4. **Deploy.** On first boot:
   - `db` builds, initializes, and imports `database/dumps/indolia_full.sql`
     (can take 30–60s).
   - `app` waits for `db` health check, then runs `storage:link`, rebuilds cached
     config/views, and starts nginx + PHP-FPM.
   - `queue` starts the database queue worker.

5. **Domain + SSL:** add your domain in Dokploy and let the reverse proxy route
   `https://indolia.de` → `app` port `APP_PORT` (default `8080`).

6. Verify:
   - Website homepage loads.
   - `/login` works with existing users.
   - File manager paths (`/storage/...`) resolve (storage symlink created at boot).
   - SMS queue: any `sms_logs` rows left `pending` process once the queue runs.

## Operational notes

- **Deploying new code** rebuilds the image; persistent data stays in the
  `app_storage` and `db_data` volumes.
- **Backup the database** (cron on the server):
  ```bash
  docker exec <db-container> mysqldump -uroot -p"$DB_ROOT_PASSWORD" \
    --single-transaction --routines --triggers indolia > indolia-$(date +%F).sql
  ```
- **Uploaded files** live in the `app_storage` volume (file manager). Back it
  up with the same frequency as the DB.
- **Sessions/cache** are file-based and stored in `app_storage`; they persist
  across redeploys (a fresh deploy runs `optimize:clear` in the entrypoint).
- **Queue**: on this project the schedule (`App\Console\Kernel`) is intentionally
  empty, so no cron is required; the `queue` service handles `SendSmsJob`.

## Local sanity check with Docker

```bash
docker compose config -q          # validates the compose file
docker compose up -d --build      # starts app, queue, db
docker compose logs -f app        # watch boot logs
```

## Files

```
Dockerfile               runtime image (nginx + php-fpm + composer vendor)
docker-compose.yml       stack definition for Dokploy
docker/Dockerfile.db     mysql image that imports the snapshot
docker/nginx.conf        Laravel vhost
docker/php.ini           PHP settings (upload limits, opcache)
docker/php-fpm.conf      FPM pool (listens 127.0.0.1:9000, inherits env)
docker/supervisord.conf  nginx + php-fpm process management
docker/entrypoint.sh     boot: storage:link, caches, permissions
database/dumps/indolia_full.sql   schema + data snapshot (5 MB, refresh as needed)
.dockerignore            keeps .env, vendor and caches out of the image
```