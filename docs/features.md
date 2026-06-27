# LTW-HRM Feature Modules

Complete feature inventory for the Human Resource Management system. Each module maps to a range of API route IDs in [`api-routes.csv`](./api-routes.csv).

The API surface is exactly the **260 routes** below — no extra modules. (The earlier scaffolded `skills` and `holidays` modules were removed as out-of-scope.)

## Modules & ownership

| # | Module | Route IDs | Phase | Owner | Scope |
|---|--------|-----------|-------|-------|-------|
| 1 | Authentication & Authorization | 1–13 | 1 (MVP) | **Dev 1** | Register, login, 2FA, password reset, email verification |
| 2 | User Management | 14–23 | 1 (MVP) | **Dev 1** | CRUD users, activate/deactivate, session control |
| 3 | Roles & Permissions (RBAC) | 24–37 | 1 (MVP) | **Dev 1** | Roles, permissions, assignment |
| 4 | Employee Management | 38–59 | 1 (MVP) | **Dev 2** | Profiles, documents, dependents, emergency contacts, termination/rehire, import/export |
| 5 | Department Management | 60–67 | 1 (MVP) | **Dev 3** | CRUD, hierarchy tree, head assignment |
| 6 | Position & Job Grades | 68–77 | 1 (MVP) | **Dev 3** | Positions, salary bands |
| 7 | Attendance | 78–93 | 1 (MVP) | **Dev 4** | Check-in/out, manual correction, late/absent, overtime |
| 8 | Leave Management | 94–108 | 1 (MVP) | **Dev 4** | Requests, approval flow, balances, leave types, calendar |
| 9 | Payroll | 109–120 | 1 (MVP) | **Dev 5** | Generation, approval, payslips, disbursement |
| 10 | Salary & Compensation | 121–142 | 1 (MVP) | **Dev 5** | Salary history, bonuses, allowances, deductions, tax rules |
| 11 | Performance & KPIs/Goals | 143–161 | 2 (post-MVP) | _unassigned_ | Reviews, 360 feedback, KPIs, OKRs |
| 12 | Recruitment | 162–189 | 2 (post-MVP) | _unassigned_ | Job postings, candidates, applications, interviews, offers, hiring |
| 13 | Training & Certifications | 190–204 | 2 (post-MVP) | _unassigned_ | Programs, enrollment, completion, certs expiry |
| 14 | Schedule & Shifts | 205–217 | 1 (MVP) | **Dev 6** | Work schedules, shifts, shift swaps |
| 15 | Reports & Analytics | 218–228 | 1 (MVP) | **Dev 3** | Dashboard, headcount, attendance, payroll, turnover, custom export |
| 16 | Documents & Contracts | 229–241 | 1 (MVP) | **Dev 6** | File upload, e-sign, expiring contracts |
| 17 | Notifications & Announcements | 242–251 | 1 (MVP) | **Dev 6** | In-app notifications, company-wide broadcasts |
| 18 | Settings & Audit | 252–260 | 1 (MVP) | **Dev 3** | Company profile, working hours, audit logs |

**Total:** 18 modules, 260 API routes.

## Phase 1 (MVP) — 6-developer split

Each lane is roughly equal by effort. Route counts differ where module complexity does:
Dev 2 owns the fewest routes because Employee Management is the single most complex module
(sub-resources: documents, dependents, emergency contacts, import/export, terminate/rehire, org-chart).

| Dev | Lane | Modules | Routes |
|-----|------|---------|--------|
| **Dev 1** | Identity & Access *(foundation)* | Auth (1–13), Users (14–23), RBAC (24–37) | 37 |
| **Dev 2** | Employee Profiles | Employees (38–59) | 22 |
| **Dev 3** | Org, Config & Analytics | Departments (60–67), Positions & Job Grades (68–77), Reports (218–228), Settings & Audit (252–260) | 38 |
| **Dev 4** | Time Management | Attendance (78–93), Leave (94–108) | 31 |
| **Dev 5** | Payroll & Compensation | Payroll (109–120), Salary & Compensation (121–142) | 34 |
| **Dev 6** | Scheduling, Docs & Comms | Schedule & Shifts (205–217), Documents & Contracts (229–241), Notifications (242–251) | 36 |

**Phase 1 (MVP) total:** 15 modules, **198 routes**.
**Phase 2 (post-MVP):** Performance, Recruitment, Training — 3 modules, **62 routes** (unassigned).

### Critical path (Phase 1)
1. **Dev 1 ships first** — Auth + RBAC + `auth:sanctum` middleware and the User model gate every other lane.
2. **Dev 2 publishes the Employee model/schema early** — Devs 4, 5, 6 all foreign-key into `employees`.
3. **Positions & Job Grades (Dev 3) feed Employees (Dev 2) and Salary (Dev 5)** — agree that schema in week 1.
4. **Reports (Dev 3) build last** — they aggregate every other module's data.
