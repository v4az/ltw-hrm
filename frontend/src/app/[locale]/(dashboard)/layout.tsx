import { SidebarNav } from "@/components/nav/sidebar-nav";
import { ThemeToggle } from "@/components/theme/theme-toggle";
import { LogoutButton } from "@/components/auth/logout-button";
import { RequireAuth } from "@/components/auth/require-auth";

export default function DashboardLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <RequireAuth>
      <div className="grid min-h-screen grid-cols-[260px_1fr] bg-white dark:bg-slate-950">
        <SidebarNav />
        <div className="flex flex-col">
          <header className="flex h-14 items-center justify-end gap-2 border-b border-slate-200 bg-white px-6 dark:border-slate-800 dark:bg-slate-950">
            <ThemeToggle />
            <LogoutButton />
          </header>
          <main className="flex-1 p-6">{children}</main>
        </div>
      </div>
    </RequireAuth>
  );
}
