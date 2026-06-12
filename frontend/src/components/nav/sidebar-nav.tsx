"use client";

import { useTranslations } from "next-intl";
import { Link, usePathname } from "@/i18n/navigation";

const NAV_GROUPS: Array<{
  heading: string;
  items: Array<{ key: string; href: string }>;
}> = [
  {
    heading: "Core",
    items: [
      { key: "dashboard", href: "/" },
      { key: "users", href: "/users" },
      { key: "roles", href: "/roles" },
    ],
  },
  {
    heading: "People",
    items: [
      { key: "employees", href: "/employees" },
      { key: "departments", href: "/departments" },
      { key: "positions", href: "/positions" },
    ],
  },
  {
    heading: "Operations",
    items: [
      { key: "attendance", href: "/attendance" },
      { key: "leaves", href: "/leaves" },
      { key: "schedules", href: "/schedules" },
      { key: "holidays", href: "/holidays" },
    ],
  },
  {
    heading: "Compensation",
    items: [
      { key: "payroll", href: "/payroll" },
      { key: "salaries", href: "/salaries" },
    ],
  },
  {
    heading: "Talent",
    items: [
      { key: "performance", href: "/performance" },
      { key: "jobs", href: "/recruitment/jobs" },
      { key: "candidates", href: "/recruitment/candidates" },
      { key: "applications", href: "/recruitment/applications" },
      { key: "interviews", href: "/recruitment/interviews" },
      { key: "training", href: "/training" },
      { key: "skills", href: "/skills" },
    ],
  },
  {
    heading: "Records",
    items: [
      { key: "documents", href: "/documents" },
      { key: "contracts", href: "/contracts" },
      { key: "reports", href: "/reports" },
    ],
  },
  {
    heading: "System",
    items: [
      { key: "notifications", href: "/notifications" },
      { key: "settings", href: "/settings" },
    ],
  },
];

export function SidebarNav() {
  const t = useTranslations("nav");
  const tCommon = useTranslations("common");
  const pathname = usePathname();

  return (
    <aside className="border-r border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-900">
      <div className="p-4 text-lg font-bold text-slate-900 dark:text-slate-100">
        {tCommon("appName")}
      </div>
      <nav className="space-y-4 px-2 pb-6">
        {NAV_GROUPS.map((group) => (
          <div key={group.heading}>
            <div className="px-2 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
              {group.heading}
            </div>
            <ul className="mt-1 space-y-0.5">
              {group.items.map((item) => {
                const active = pathname === item.href;
                return (
                  <li key={item.key}>
                    <Link
                      href={item.href}
                      className={`block rounded-md px-3 py-1.5 text-sm ${
                        active
                          ? "bg-slate-200 font-medium text-slate-900 dark:bg-slate-800 dark:text-slate-100"
                          : "text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                      }`}
                    >
                      {t(item.key)}
                    </Link>
                  </li>
                );
              })}
            </ul>
          </div>
        ))}
      </nav>
    </aside>
  );
}
