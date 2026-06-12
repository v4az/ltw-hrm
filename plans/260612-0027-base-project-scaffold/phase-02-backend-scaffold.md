# Phase 2 — Backend Scaffold (Laravel)

## Context Links
- Parent plan: [plan.md](./plan.md)
- Feature inventory: `docs/features.md`
- Route catalog: `docs/api-routes.csv`
- Depends on: [phase-01](./phase-01-cleanup-and-config.md)

## Overview
- **Priority**: P0
- **Status**: pending
- Scaffold one **Model + Controller + Migration + Route file** per HRM module. Every file is a placeholder: class declared, methods stubbed with `// TODO` body, return `response()->json(['todo' => 'method_name'])`.

## Key Insights
- 20 modules from `docs/features.md`. Each gets its own folder under `app/Http/Controllers/Api/V1/{Module}/` so namespacing maps 1:1 to URL.
- Use Laravel artisan generators (`make:controller --api --model`, `make:migration`) — they produce the right boilerplate, we just empty the method bodies.
- Models grouped under `app/Models/` flat (Laravel convention).
- Route per-module files included from `routes/api.php` to keep that file small (already-stubbed in phase 1).
- Spatie HasRoles trait added to `User` model only.

## Requirements
- **Functional**: every route in `docs/api-routes.csv` (272 entries) has a controller method, returning placeholder JSON.
- **Non-functional**: `php artisan route:list` shows all 272 routes; no class missing.

## Architecture

```
backend/app/
├── Http/Controllers/Api/V1/
│   ├── Auth/AuthController.php
│   ├── User/UserController.php
│   ├── Role/RoleController.php
│   ├── Permission/PermissionController.php
│   ├── Employee/EmployeeController.php
│   ├── Department/DepartmentController.php
│   ├── Position/{PositionController, JobGradeController}.php
│   ├── Attendance/{AttendanceController, OvertimeController}.php
│   ├── Leave/{LeaveController, LeaveTypeController}.php
│   ├── Payroll/{PayrollController, PayslipController}.php
│   ├── Salary/{SalaryController, BonusController, AllowanceController,
│   │            DeductionController, TaxRuleController}.php
│   ├── Performance/{PerformanceController, KpiController, GoalController}.php
│   ├── Recruitment/{JobController, CandidateController, ApplicationController,
│   │                InterviewController}.php
│   ├── Training/{TrainingController, CertificationController}.php
│   ├── Skill/SkillController.php
│   ├── Schedule/{ScheduleController, ShiftController}.php
│   ├── Holiday/HolidayController.php
│   ├── Report/ReportController.php
│   ├── Document/{DocumentController, ContractController}.php
│   ├── Notification/{NotificationController, AnnouncementController}.php
│   └── Setting/{SettingController, AuditLogController}.php
├── Models/
│   ├── Employee.php             Department.php       Position.php
│   ├── JobGrade.php             Attendance.php       Overtime.php
│   ├── Leave.php                LeaveType.php        Payroll.php
│   ├── Payslip.php              Salary.php           Bonus.php
│   ├── Allowance.php            Deduction.php        TaxRule.php
│   ├── Performance.php          Kpi.php              Goal.php
│   ├── Job.php                  Candidate.php        Application.php
│   ├── Interview.php            Training.php         Certification.php
│   ├── Skill.php                Schedule.php         Shift.php
│   ├── Holiday.php              Document.php         Contract.php
│   ├── Notification.php         Announcement.php     Setting.php
│   └── AuditLog.php
└── routes/api/v1/
    ├── auth.php                 users.php            roles.php
    ├── employees.php            departments.php      positions.php
    ├── attendance.php           leaves.php           payroll.php
    ├── salaries.php             performance.php      recruitment.php
    ├── training.php             skills.php           schedules.php
    ├── holidays.php             reports.php          documents.php
    ├── notifications.php        settings.php
    └── ...
```

## Related Code Files
**Create** (placeholders, all with `// TODO: implement` bodies):
- ~40 controller files under `app/Http/Controllers/Api/V1/`
- ~35 model files under `app/Models/`
- ~35 migration files (`xxxx_create_{table}_table.php`) — schema is **EMPTY** beyond `id()` and `timestamps()`
- ~20 route files under `routes/api/v1/{module}.php`

**Modify**
- `app/Models/User.php` → add `HasApiTokens`, `HasRoles` traits
- `routes/api.php` → `Route::prefix('v1')->group(fn() => [...includes...])`

## Implementation Steps
1. Edit `User` model: add `use HasApiTokens, HasRoles;`.
2. For each module, run `php artisan make:model {Name} -mc --api`.
   - Wipes default `up()` body except `$table->id();$table->timestamps();` plus `// TODO: columns`.
   - Controller methods (`index/store/show/update/destroy`) return `response()->json(['todo' => __FUNCTION__])`.
3. For non-CRUD action routes (e.g. `POST /leaves/:id/approve`), add **custom methods** with the same placeholder body.
4. Create per-module route files under `routes/api/v1/`. Each file declares `Route::apiResource(...)` plus extra `Route::post/get` for action routes from `docs/api-routes.csv`.
5. In `routes/api.php`, `Route::prefix('v1')->middleware('auth:sanctum')->group(function() { require 'api/v1/users.php'; ... })`. Auth file stays outside middleware.

## Todo List
- [ ] Add Sanctum + Spatie traits to `User` model
- [ ] Scaffold Auth module (controllers + routes, no model needed)
- [ ] Scaffold User / Role / Permission modules
- [ ] Scaffold Employee / Department / Position / JobGrade modules
- [ ] Scaffold Attendance / Overtime modules
- [ ] Scaffold Leave / LeaveType modules
- [ ] Scaffold Payroll / Payslip modules
- [ ] Scaffold Salary / Bonus / Allowance / Deduction / TaxRule modules
- [ ] Scaffold Performance / Kpi / Goal modules
- [ ] Scaffold Recruitment (Job, Candidate, Application, Interview)
- [ ] Scaffold Training / Certification modules
- [ ] Scaffold Skill module
- [ ] Scaffold Schedule / Shift modules
- [ ] Scaffold Holiday module
- [ ] Scaffold Report module (read-only, no model)
- [ ] Scaffold Document / Contract modules
- [ ] Scaffold Notification / Announcement modules
- [ ] Scaffold Setting / AuditLog modules
- [ ] Wire `routes/api.php` with v1 prefix + middleware
- [ ] Verify `php artisan route:list` lists all 272 routes

## Success Criteria
- `php artisan route:list --path=api` outputs 272 routes (count must match CSV).
- Every controller class compiles; every route resolves to an existing method.
- `php artisan migrate:fresh` runs without error (migrations exist but only base columns).

## Risk Assessment
- **Risk**: route count drift vs CSV. **Mitigation**: post-step script `php artisan route:list --json | jq length` compared against CSV row count.
- **Risk**: namespace typos break autoload. **Mitigation**: use artisan generators rather than hand-written stubs.
- **Risk**: enormous PR if all in one go. **Mitigation**: commit per module group.

## Security Considerations
- Auth routes (`/api/v1/auth/*`) live OUTSIDE `auth:sanctum` middleware. Everything else inside.
- Public routes (`/api/v1/jobs/public`) need explicit middleware exception.

## Next Steps
- Phase 3 (frontend) consumes the route shape established here.
