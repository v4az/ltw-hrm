# LTW-HRM

Human Resource Management system. Laravel API backend + Next.js dashboard frontend.

- **20 modules**, **272 API routes** (see [`docs/api-routes.csv`](./docs/api-routes.csv) and [`docs/features.md`](./docs/features.md))
- Vietnamese (default) + English UI
- Light / dark / system theme

## Tech Stack

| Layer | Choice |
|-------|--------|
| Backend | Laravel 13 (PHP 8.3) |
| Auth | Laravel Sanctum (token) |
| RBAC | spatie/laravel-permission |
| Database | MySQL 8 |
| Frontend | Next.js 16 (App Router) + React 19 |
| Styling | Tailwind CSS v4 (no UI lib) |
| i18n | next-intl |
| Theme | next-themes |
| Package manager | Bun (FE), Composer (BE) |
| Lint | Biome (FE), Pint (BE) |

## Prerequisites

You need **PHP, Composer, Bun (or Node), and MySQL** (either via Docker or installed natively).

### Linux

```bash
# Ubuntu / Debian
sudo apt install php8.3 php8.3-cli php8.3-mbstring php8.3-xml php8.3-curl php8.3-mysql php8.3-zip composer
curl -fsSL https://bun.sh/install | bash      # or use volta / nvm

# Arch
sudo pacman -S php composer bun
```

### Windows

Install via [winget](https://learn.microsoft.com/en-us/windows/package-manager/winget/) (recommended):

```powershell
winget install ShiningLight.OpenSSL.Light
winget install --id PHP.PHP -v 8.3        # or use https://laravel.com/docs/installation
winget install Composer.Composer
winget install Oven-sh.Bun
```

Alternatives:
- [Laravel Herd](https://herd.laravel.com/windows) — bundles PHP + Composer + Node for Windows
- [XAMPP](https://www.apachefriends.org/) — bundles PHP + MySQL + Apache

Open a fresh terminal after install so the new PATH entries are visible.

---

## MySQL — choose one

### Option A — Docker (works on Linux + Windows, recommended)

You need [Docker Desktop (Windows)](https://www.docker.com/products/docker-desktop/) or [Docker Engine (Linux)](https://docs.docker.com/engine/install/).

```bash
docker compose up -d mysql
```

That spins up MySQL 8 on `127.0.0.1:3306` with:
- Database: `ltw_hrm`
- User: `ltw` / password: `ltw_pass`
- Root password: `secret`

These credentials match `backend/.env.example` out of the box — no edits required.

Stop / restart:

```bash
docker compose stop mysql        # stop
docker compose up -d mysql       # restart
docker compose down -v           # nuke including data volume
```

### Option B — Local MySQL install

#### Linux

```bash
# Ubuntu / Debian
sudo apt install mysql-server
sudo systemctl enable --now mysql
sudo mysql_secure_installation

# Arch
sudo pacman -S mariadb            # MariaDB is a drop-in replacement
sudo mariadb-install-db --user=mysql --basedir=/usr --datadir=/var/lib/mysql
sudo systemctl enable --now mariadb
```

#### Windows

Use the [MySQL Installer](https://dev.mysql.com/downloads/installer/), or:

```powershell
winget install Oracle.MySQL
# starts service automatically; configure root password during install
```

#### Create the database + user (any OS)

```bash
mysql -u root -p
```

```sql
CREATE DATABASE ltw_hrm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'ltw'@'localhost' IDENTIFIED BY 'ltw_pass';
GRANT ALL PRIVILEGES ON ltw_hrm.* TO 'ltw'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

If you used a different host / user / password, edit `backend/.env` to match (see next section).

---

## Backend setup

```bash
cd backend
composer install

# Create local env file
cp .env.example .env             # Linux / macOS
# copy .env.example .env         # Windows cmd
# Copy-Item .env.example .env    # PowerShell

php artisan key:generate
php artisan install:api          # publishes Sanctum config + migration
php artisan vendor:publish       # interactive — pick permission-config + permission-migrations
php artisan migrate              # apply all migrations
```

Verify:

```bash
php artisan route:list --path=api | grep -c "GET\|POST\|PUT\|PATCH\|DELETE"
# expected: 272
```

Start the dev server:

```bash
php artisan serve                # http://127.0.0.1:8000
```

## Frontend setup

```bash
cd frontend
bun install
bun run dev                      # http://localhost:3000
```

Open <http://localhost:3000> — you'll be redirected to `/vi/login`. Use `/en/login` for English.

Build for production:

```bash
bun run build
bun run start
```

---

## Common commands

### Backend

```bash
php artisan serve                # dev server
php artisan migrate              # apply migrations
php artisan migrate:fresh        # drop all + remigrate
php artisan tinker               # REPL
php artisan route:list           # list every route
./vendor/bin/pint                # format PHP
./vendor/bin/phpunit             # run tests
```

### Frontend

```bash
bun run dev                      # dev server (with Turbopack)
bun run build                    # production build
bun run lint                     # Biome check
bun run format                   # Biome format
```

---

## Project structure

```
ltw-hrm/
├── backend/                     # Laravel 13 API
│   ├── app/
│   │   ├── Http/Controllers/Api/V1/   # 20 modules, ~40 controllers
│   │   └── Models/                    # 35+ Eloquent models
│   ├── database/migrations/           # 39 placeholder migrations
│   ├── routes/
│   │   ├── api.php                    # /api/v1 manifest
│   │   └── api/v1/                    # per-module route files
│   └── .env.example
├── frontend/                    # Next.js 16 dashboard
│   ├── src/
│   │   ├── app/[locale]/(auth|dashboard)/
│   │   ├── components/{nav,theme,providers}/
│   │   ├── i18n/                      # next-intl config
│   │   └── lib/api/                   # API client stubs
│   └── messages/{vi,en}.json
├── docs/                        # feature inventory + route catalog
└── docker-compose.yml           # MySQL 8 service
```

## Environment variables

`backend/.env` (created from `.env.example`):

| Var | Default | Purpose |
|-----|---------|---------|
| `APP_URL` | `http://localhost:8000` | API base URL |
| `FRONTEND_URL` | `http://localhost:3000` | Used by Sanctum CORS |
| `APP_LOCALE` | `vi` | Server-side locale |
| `DB_*` | `ltw_hrm` / `ltw` / `ltw_pass` | MySQL connection |
| `SANCTUM_STATEFUL_DOMAINS` | `localhost:3000` | SPA auth |

`frontend/.env.local` (create if needed):

```bash
NEXT_PUBLIC_API_URL=http://localhost:8000/api/v1
```

---

## Troubleshooting

| Symptom | Fix |
|---------|-----|
| `SQLSTATE[HY000] [2006] MySQL server has gone away` right after `docker compose up` | MySQL is still initializing inside the container. Wait ~20s and retry. |
| `php artisan vendor:publish` shows no Sanctum/Spatie entries | Run `composer install` first. Use `php artisan vendor:publish` interactively (no `--provider`) to see all tags. |
| `bun run dev` 404 on `/login` | Locale prefix is required — use `/vi/login` or `/en/login`. |
| `CORS error` from FE to BE | Check `SANCTUM_STATEFUL_DOMAINS` in `backend/.env` matches your FE host:port. |
| Windows PHP `php_pdo_mysql.dll` missing | Enable `extension=pdo_mysql` in `php.ini`. |
