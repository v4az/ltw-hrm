# Phase 1 — Cleanup & Config

## Context Links
- Parent plan: [plan.md](./plan.md)
- Backend root: `backend/`
- Frontend root: `frontend/`

## Overview
- **Priority**: P0 (blocker for phase 2/3)
- **Status**: pending
- Delete default Next.js boilerplate assets and default Laravel test stubs, then install required packages: Composer (Sanctum, Spatie Permission) + Bun (next-intl). Tailwind v4 stays as-is — no UI component library will be added.

## Key Insights
- Backend uses Laravel 13 (PHP 8.3) — `routes/api.php` does NOT exist by default in L11+, must be created and registered via `bootstrap/app.php`.
- Frontend uses Next 16 App Router + Tailwind v4 + Bun.
- Existing default `User` model + initial migrations stay (Sanctum hooks into them).

## Requirements
- **Functional**: clean slate without business stubs polluted by Laravel/Next defaults; packages installed; routing wiring ready.
- **Non-functional**: idempotent (safe to re-run), no broken imports after deletion.

## Architecture
```
backend/
├── routes/
│   ├── api.php          ← NEW (will be populated in phase 2)
│   ├── api/             ← NEW (per-module route files)
│   └── web.php          ← keep (default L welcome)
├── bootstrap/app.php    ← register routes/api.php
└── config/             ← Sanctum + Permission configs published

frontend/
├── src/app/
│   ├── (auth)/          ← NEW (auth pages group)
│   ├── (dashboard)/     ← NEW (authed area group)
│   ├── layout.tsx       ← keep, edit
│   ├── page.tsx         ← keep, replace
│   └── globals.css      ← keep
└── public/              ← strip default svg assets
```

## Related Code Files
**To delete**
- `frontend/public/{next,vercel,file,globe,window}.svg`
- `backend/tests/Unit/ExampleTest.php`
- `backend/tests/Feature/ExampleTest.php`

**To create**
- `backend/routes/api.php`
- `backend/routes/api/v1.php` (manifest including module files)
- `backend/.env.example` updates (MySQL creds match `docker-compose.yml`)
- `backend/lang/vi/` mirror of `lang/en/` (placeholder values)
- `frontend/messages/vi.json` and `frontend/messages/en.json` (seed namespaces: `common`, `auth`, `nav`)
- `frontend/src/i18n/request.ts` (next-intl request config)
- `frontend/src/middleware.ts` (next-intl locale routing)

**To modify**
- `backend/bootstrap/app.php` — register `api.php` with prefix `api`
- `backend/composer.json` — add `laravel/sanctum`, `spatie/laravel-permission`
- `backend/config/app.php` — `locale => 'vi'`, `fallback_locale => 'en'`
- `frontend/package.json` — add `next-intl`, `next-themes`. Keep `tailwindcss` + `@tailwindcss/postcss` as-is.
- `frontend/next.config.ts` — wrap with `createNextIntlPlugin()`
- `frontend/src/app/globals.css` — add `@custom-variant dark (&:where(.dark, .dark *));` after `@import "tailwindcss";`

## Implementation Steps

### Backend
1. `cd backend && composer require laravel/sanctum spatie/laravel-permission`
2. `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
3. `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`
4. Edit `bootstrap/app.php` → add `api: __DIR__.'/../routes/api.php'` in `withRouting()`.
5. Create `routes/api.php`, prefix `v1`, include module route files (placeholder `require __DIR__.'/api/v1/...'` stubs).
6. Update `.env.example` → `DB_HOST=127.0.0.1`, `DB_DATABASE=ltw_hrm`, `DB_USERNAME=ltw`, `DB_PASSWORD=ltw_pass`, `APP_LOCALE=vi`, `APP_FALLBACK_LOCALE=en`.
7. `php artisan lang:publish` then create `lang/vi/` mirror of `lang/en/` (placeholder values OK for now).
8. Delete `backend/tests/{Unit,Feature}/ExampleTest.php`.

### Frontend
9. `cd frontend && bun add next-intl next-themes`
10. Delete `frontend/public/{next,vercel,file,globe,window}.svg`.
11. Create `src/i18n/request.ts` (next-intl `getRequestConfig`).
12. Create `src/middleware.ts` (next-intl `createMiddleware({ locales: ['vi','en'], defaultLocale: 'vi' })`).
13. Wrap `next.config.ts` export with `createNextIntlPlugin('./src/i18n/request.ts')(nextConfig)`.
14. Edit `src/app/globals.css`: after `@import "tailwindcss";` add `@custom-variant dark (&:where(.dark, .dark *));` (enables class-based dark mode).
15. Create `messages/vi.json`, `messages/en.json` with stubs: `{ "common": { "appName": "LTW-HRM" }, "auth": {}, "nav": {}, "theme": { "light": "Sáng", "dark": "Tối", "system": "Hệ thống" } }` (en mirror in English).

## Todo List
- [ ] Install Sanctum + Spatie Permission via Composer
- [ ] Publish package configs (Sanctum, Permission)
- [ ] Register `routes/api.php` in `bootstrap/app.php`
- [ ] Create `routes/api.php` with `/v1` prefix
- [ ] Update `.env.example` (DB creds + locale vars)
- [ ] Publish + mirror `lang/vi` from `lang/en`
- [ ] Install next-intl + next-themes in frontend
- [ ] Add `@custom-variant dark` to `globals.css`
- [ ] Delete default SVG assets
- [ ] Create `src/i18n/request.ts`, `src/middleware.ts`
- [ ] Wrap `next.config.ts` with `createNextIntlPlugin`
- [ ] Create `messages/{vi,en}.json` seed files
- [ ] Delete `ExampleTest.php` files

## Success Criteria
- `php artisan route:list` runs without error (only Sanctum CSRF visible).
- `composer.json` lists Sanctum + Spatie Permission in `require`.
- `frontend/package.json` lists `next-intl` and `next-themes`; Tailwind kept.
- `bun run build` succeeds.
- Visiting `/` redirects to `/vi` (or `/en` per Accept-Language) without 404.

## Risk Assessment
- **Risk**: Sanctum migration table conflict with `users` table edits. **Mitigation**: don't edit `users` migration in this phase.
- **Risk**: Spatie config customisation overlooked. **Mitigation**: keep defaults, document in phase 2.

## Security Considerations
- `.env` MUST stay gitignored (already is). `.env.example` carries placeholder creds only.
- Sanctum CSRF cookie origin must be locked to frontend dev URL later (out-of-scope here).

## Next Steps
- Unblocks Phase 2 (backend scaffold) which depends on `routes/api.php` existing.
