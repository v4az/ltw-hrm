# Phase 3 — Frontend Scaffold (Next.js)

## Context Links
- Parent plan: [plan.md](./plan.md)
- Feature inventory: `docs/features.md`
- Depends on: [phase-02](./phase-02-backend-scaffold.md) (uses `/api/v1/*` URL shape)

## Overview
- **Priority**: P0
- **Status**: pending
- Scaffold the Next.js App Router structure under `src/app/[locale]/`: `(auth)` and `(dashboard)` route groups. Root layout wires `NextIntlClientProvider` (i18n) and `next-themes` `ThemeProvider` (dark/light). Every module page returns a placeholder `<h1>{t('title')}</h1>` styled with Tailwind utility classes that respect dark-mode variants + `// TODO` comment.

## Key Insights
- Next 16 App Router — `[locale]` dynamic segment wraps everything for next-intl URL prefixing.
- next-intl 3.x: server components use `useTranslations()`; client components wrap in `NextIntlClientProvider`.
- next-themes: `attribute="class"` toggles `<html class="dark">`; `suppressHydrationWarning` on `<html>` is mandatory to avoid the React hydration warning from the pre-render theme script.
- Dark variant in Tailwind v4: declared in CSS via `@custom-variant dark (&:where(.dark, .dark *));` (phase 1). Then use `dark:bg-slate-900` etc. directly in markup.
- No UI library — components built from scratch using Tailwind v4 utility classes.
- Bun for install/scripts; Biome for lint/format.
- No state management lib yet — defer.

## Requirements
- **Functional**: every HRM module from `docs/features.md` has a corresponding page route under `(dashboard)/`. Auth pages under `(auth)/`.
- **Non-functional**: `bun run build` succeeds; `bun run lint` passes.

## Architecture

```
frontend/src/
├── i18n/
│   └── request.ts                  ← next-intl getRequestConfig
├── middleware.ts                   ← next-intl locale routing
│
├── app/
│   ├── layout.tsx                  ← html root (lang from locale)
│   ├── globals.css                 ← keep Tailwind directives
│   │
│   └── [locale]/
│       ├── layout.tsx              ← NextIntlClientProvider wrapper
│       ├── page.tsx                ← landing redirect to /[locale]/login or /[locale]/dashboard
│       │
│       ├── (auth)/
│       │   ├── layout.tsx          ← centered card (Tailwind: min-h-screen grid place-items-center)
│       │   ├── login/page.tsx
│       │   ├── register/page.tsx
│       │   ├── forgot-password/page.tsx
│       │   └── reset-password/page.tsx
│       │
│       └── (dashboard)/
│           ├── layout.tsx          ← sidebar + topbar (Tailwind: grid grid-cols-[240px_1fr])
│           ├── page.tsx            ← dashboard home (metrics placeholder)
│           │
│           ├── users/page.tsx        roles/page.tsx          employees/page.tsx
│           ├── departments/page.tsx  positions/page.tsx      attendance/page.tsx
│           ├── leaves/page.tsx       payroll/page.tsx        salaries/page.tsx
│           ├── performance/page.tsx
│           ├── recruitment/{jobs,candidates,applications,interviews}/page.tsx
│           ├── training/page.tsx     skills/page.tsx         schedules/page.tsx
│           ├── holidays/page.tsx     reports/page.tsx        documents/page.tsx
│           ├── contracts/page.tsx    notifications/page.tsx  settings/page.tsx
│           └── ...
│
├── components/
│   ├── providers/app-providers.tsx ← stacked: ThemeProvider + NextIntlClientProvider
│   ├── theme/theme-toggle.tsx      ← light/dark/system switcher (client)
│   └── nav/sidebar-nav.tsx         ← module link list (placeholder)
│
└── lib/
    ├── api/
    │   ├── client.ts               ← TODO: fetch wrapper w/ Sanctum token
    │   └── endpoints.ts            ← TODO: typed route constants from api-routes.csv
    └── types/
        └── index.ts                ← TODO: shared TS types

frontend/messages/
├── vi.json                         ← namespaces: common, nav, auth, modules
└── en.json
```

## Related Code Files
**Create**
- ~30 `page.tsx` files under `src/app/[locale]/(auth|dashboard)/...`
- `[locale]/layout.tsx`, `(auth)/layout.tsx`, `(dashboard)/layout.tsx`
- `[locale]/page.tsx` (root index — redirect to dashboard or login)
- `components/providers/app-providers.tsx`
- `components/theme/theme-toggle.tsx`
- `components/nav/sidebar-nav.tsx`
- `src/lib/api/client.ts`, `src/lib/api/endpoints.ts`, `src/lib/types/index.ts`

**Modify**
- `src/app/layout.tsx` — minimal HTML wrapper with `<html lang suppressHydrationWarning>`, metadata title `LTW-HRM`
- Delete the original `src/app/page.tsx` (replaced by `[locale]/page.tsx`)

## Implementation Steps
1. Delete `src/app/page.tsx` (moved under `[locale]`).
2. Update `src/app/layout.tsx`: `<html lang={locale} suppressHydrationWarning>`, metadata `title: "LTW-HRM"`.
3. Create `components/providers/app-providers.tsx` (client component):
   ```tsx
   "use client";
   import { NextIntlClientProvider } from "next-intl";
   import { ThemeProvider } from "next-themes";
   export function AppProviders({ children, messages, locale }) {
     return (
       <NextIntlClientProvider messages={messages} locale={locale}>
         <ThemeProvider attribute="class" defaultTheme="system" enableSystem>
           {children}
         </ThemeProvider>
       </NextIntlClientProvider>
     );
   }
   ```
4. Create `src/app/[locale]/layout.tsx`:
   - server component, calls `getMessages()`
   - wraps children in `<AppProviders messages locale>`
5. Create `[locale]/page.tsx` — server component, `redirect('/[locale]/login')` for now.
6. Create `components/theme/theme-toggle.tsx` (client) — cycles `light → dark → system` via `useTheme()`, uses `useTranslations('theme')` for label.
7. Create `[locale]/(auth)/layout.tsx` — `<main class="min-h-screen grid place-items-center bg-slate-50 dark:bg-slate-950">`.
8. Create 4 auth pages (login, register, forgot-password, reset-password) returning `<h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">{t('title')}</h1>` placeholder.
9. Create `[locale]/(dashboard)/layout.tsx` — `<div class="grid grid-cols-[240px_1fr] min-h-screen bg-white dark:bg-slate-950">` with `<SidebarNav />` + `<main class="p-6">{children}</main>` + `<ThemeToggle />` in topbar.
10. Create `components/nav/sidebar-nav.tsx` — link list to every module (use `useTranslations('nav')`).
11. For each module, create `(dashboard)/{module}/page.tsx` returning `<h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{t('modules.{module}')}</h1>` + TODO marker.
12. Create `lib/api/client.ts`:
    ```ts
    // TODO: implement fetch wrapper with Sanctum token + CSRF handling
    export const api = { /* TODO */ };
    ```
13. Create `lib/api/endpoints.ts` exporting `const API_BASE = "/api/v1"` + `// TODO: typed routes`.
14. Populate `messages/{vi,en}.json` with `common.appName`, `nav.{module}`, `modules.{module}`, `auth.{login,register,...}`, `theme.{light,dark,system}` keys.
15. Run `bun run build` and `bun run lint` to verify.

## Todo List
- [ ] Delete original `src/app/page.tsx`
- [ ] Update root `layout.tsx` metadata
- [ ] Create `components/providers/app-providers.tsx` (NextIntl + next-themes)
- [ ] Create `[locale]/layout.tsx` using `<AppProviders>`
- [ ] Create `[locale]/page.tsx` (redirect)
- [ ] Create `components/theme/theme-toggle.tsx`
- [ ] Create `(auth)` layout + 4 auth pages (with dark variants)
- [ ] Create `(dashboard)` layout w/ sidebar nav + theme toggle in topbar
- [ ] Create `components/nav/sidebar-nav.tsx`
- [ ] Create dashboard home page
- [ ] Create page stubs for all 20 dashboard modules (incl. recruitment subroutes)
- [ ] Populate `messages/{vi,en}.json` seed keys
- [ ] Create `lib/api/client.ts`, `endpoints.ts`, `types/index.ts`
- [ ] Verify `bun run build` and `bun run lint` pass

## Success Criteria
- `bun run build` → success.
- `bun run lint` → 0 errors.
- Visiting `/vi/login`, `/vi`, `/vi/employees`, `/en/employees`, etc. in `bun run dev` shows placeholder pages without 404.
- Switching locale (`/vi` vs `/en`) flips placeholder copy via next-intl.
- Theme toggle cycles light → dark → system; `<html>` element gets `class="dark"` added in dark mode without page flash on reload.
- Sidebar contains link to every module.

## Risk Assessment
- **Risk**: file name collisions in route groups. **Mitigation**: only `(dashboard)/page.tsx` exists at the `[locale]` root level via the dashboard group; auth pages all live under `/login`, `/register` etc.
- **Risk**: next-intl middleware vs `[locale]` segment misconfig — common 404 source. **Mitigation**: follow next-intl App Router quickstart exactly (`middleware.ts` at `src/`, `i18n/request.ts`).
- **Risk**: hydration mismatch warning from next-themes if `suppressHydrationWarning` omitted. **Mitigation**: add it to `<html>` in root `layout.tsx` (only suppresses the warning on that single element).
- **Risk**: Theme flash (FOUC) on first paint. **Mitigation**: next-themes injects a synchronous pre-paint script when wrapped properly — verify by reloading in dark mode and watching for white flash.
- **Risk**: Tailwind v4 + React 19 + React Compiler quirks. **Mitigation**: keep `globals.css` minimal beyond the `@import` + `@custom-variant dark`, don't introduce custom theme config in this phase.

## Security Considerations
- API client placeholder must NEVER store token in `localStorage` in real impl (use httpOnly cookie). Document as TODO.

## Next Steps
- Both phases complete → scaffold ready. Real implementation work picks up per module in subsequent plans.
