"use client";

import { useEffect, useState } from "react";
import { useRouter } from "@/i18n/navigation";
import { getAccessToken } from "@/lib/auth/tokens";

/**
 * Wraps the auth pages: if an access token is already present, redirect to the
 * dashboard instead of showing the login/register forms.
 */
export function GuestOnly({ children }: { children: React.ReactNode }) {
  const router = useRouter();
  const [ready, setReady] = useState(false);

  useEffect(() => {
    if (getAccessToken()) {
      router.replace("/");
    } else {
      setReady(true);
    }
  }, [router]);

  if (!ready) {
    return null;
  }

  return <>{children}</>;
}
