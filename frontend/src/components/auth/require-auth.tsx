"use client";

import { useEffect, useState } from "react";
import { useTranslations } from "next-intl";
import { useRouter } from "@/i18n/navigation";
import { getAccessToken } from "@/lib/auth/tokens";

/**
 * Client-side route guard for the dashboard. Redirects to /login when no
 * access token is present. Real authorization is enforced by the API.
 */
export function RequireAuth({ children }: { children: React.ReactNode }) {
  const router = useRouter();
  const t = useTranslations("common");
  const [ready, setReady] = useState(false);

  useEffect(() => {
    if (!getAccessToken()) {
      router.replace("/login");
    } else {
      setReady(true);
    }
  }, [router]);

  if (!ready) {
    return (
      <div className="grid h-full place-items-center p-10 text-sm text-slate-500">
        {t("loading")}
      </div>
    );
  }

  return <>{children}</>;
}
