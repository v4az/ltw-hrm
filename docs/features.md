# LTW-HRM Feature Modules

Complete feature inventory for the Human Resource Management system. Each module maps to a range of API route IDs in [`api-routes.csv`](./api-routes.csv).

| # | Module | Route IDs | Scope |
|---|--------|-----------|-------|
| 1 | Authentication & Authorization | 1–13 | Register, login, 2FA, password reset, email verification |
| 2 | User Management | 14–23 | CRUD users, activate/deactivate, session control |
| 3 | Roles & Permissions (RBAC) | 24–37 | Roles, permissions, assignment |
| 4 | Employee Management | 38–59 | Profiles, documents, dependents, emergency contacts, termination/rehire, import/export |
| 5 | Department Management | 60–67 | CRUD, hierarchy tree, head assignment |
| 6 | Position & Job Grades | 68–77 | Positions, salary bands |
| 7 | Attendance | 78–93 | Check-in/out, manual correction, late/absent, overtime |
| 8 | Leave Management | 94–108 | Requests, approval flow, balances, leave types, calendar |
| 9 | Payroll | 109–120 | Generation, approval, payslips, disbursement |
| 10 | Salary & Compensation | 121–142 | Salary history, bonuses, allowances, deductions, tax rules |
| 11 | Performance & KPIs/Goals | 143–161 | Reviews, 360 feedback, KPIs, OKRs |
| 12 | Recruitment | 162–189 | Job postings, candidates, applications, interviews, offers, hiring |
| 13 | Training & Certifications | 190–204 | Programs, enrollment, completion, certs expiry |
| 14 | Schedule & Shifts | 205–217 | Work schedules, shifts, shift swaps |
| 15 | Reports & Analytics | 218–228 | Dashboard, headcount, attendance, payroll, turnover, custom export |
| 16 | Documents & Contracts | 229–241 | File upload, e-sign, expiring contracts |
| 17 | Notifications & Announcements | 242–251 | In-app notifications, company-wide broadcasts |
| 18 | Settings & Audit | 252–260 | Company profile, working hours, audit logs |

**Total:** 18 modules, 260 API routes.
