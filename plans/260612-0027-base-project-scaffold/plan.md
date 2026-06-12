---
title: Base Project Scaffold (LTW-HRM)
created: 2026-06-12
completed: 2026-06-12
status: completed
blockedBy: []
blocks: []
---

# Base Project Scaffold (LTW-HRM)

Scaffold the base structure for the HRM system based on the 20 modules in [`docs/features.md`](../../docs/features.md). Every file is a **placeholder** with TODO comments — no business logic. Remove default Laravel/Next.js boilerplate not needed for the project.

## Decisions

| Item | Choice |
|------|--------|
| Backend | Laravel 13 + PHP 8.3 |
| Frontend | Next.js 16 (App Router) + React 19 + Bun |
| UI lib | **None** — raw React + Tailwind (build components in-house) |
| Styling | Tailwind v4 (already installed) |
| Theme | `next-themes` — class-based toggle (`light` / `dark` / `system`) |
| i18n | `next-intl` (FE), Laravel built-in `lang/{vi,en}` (BE). Default locale: `vi`. |
| Lint | Biome (FE), Pint (BE) |
| Auth | Laravel Sanctum (token) |
| RBAC | spatie/laravel-permission |
| API prefix | `/api/v1/*` |
| FE layout | `src/app/[locale]/(dashboard)/{module}/` route groups |
| DB | MySQL 8 (docker-compose) |

## Phases

| # | Phase | Status |
|---|-------|--------|
| 1 | [Cleanup & Config](./phase-01-cleanup-and-config.md) | completed |
| 2 | [Backend Scaffold](./phase-02-backend-scaffold.md) | completed |
| 3 | [Frontend Scaffold](./phase-03-frontend-scaffold.md) | completed |

## Outcome (2026-06-12)
- **Backend**: 39 controllers + 39 models + 39 migrations + 21 route files generated. `composer.json` updated (Sanctum + Spatie/permission added — user runs `composer install` to fetch). `User` model traits wired. `bootstrap/app.php` registers `api.php` with `auth:sanctum` middleware.
- **Frontend**: `bun run build` ✓ (59 routes), `bun run lint` ✓. `next-intl` + `next-themes` installed, locale segment `[locale]` wired, `(auth)`/`(dashboard)` route groups with 28 placeholder pages, theme toggle + sidebar nav working.
- **Follow-up for user**:
  1. `cd backend && composer install` (then `vendor:publish` for Sanctum + Spatie)
  2. `cd backend && cp .env.example .env && php artisan key:generate && php artisan migrate`
  3. `cd frontend && bun run dev`

## Source References
- Feature inventory: `docs/features.md`
- Route catalog: `docs/api-routes.csv` (272 routes, 20 modules)
- Docker MySQL: `docker-compose.yml`

## Dependencies
- Phase 1 → Phase 2 → Phase 3 (sequential, FE depends on BE conventions)

## Out of Scope
- Business logic, validation rules, DB schemas (columns), tests
- Auth flow implementation (only stubs)
- UI components beyond layout shell (no design system yet)
- Translation copy beyond a handful of keys per namespace (just structural seed)
