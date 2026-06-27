"use client";

import { useState } from "react";
import { useTranslations } from "next-intl";
import { useRouter } from "@/i18n/navigation";
import { logout } from "@/lib/api/auth";

export function LogoutButton() {
  const t = useTranslations("auth");
  const router = useRouter();
  const [loading, setLoading] = useState(false);

  async function onClick() {
    setLoading(true);
    await logout();
    router.replace("/login");
  }

  return (
    <button
      type="button"
      onClick={onClick}
      disabled={loading}
      className="rounded-md px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100 disabled:opacity-60 dark:text-slate-200 dark:hover:bg-slate-800"
    >
      {t("logout")}
    </button>
  );
}
