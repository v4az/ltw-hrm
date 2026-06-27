"use client";

import { type FormEvent, useState } from "react";
import { useTranslations } from "next-intl";
import { Link, useRouter } from "@/i18n/navigation";
import { ApiError } from "@/lib/api/client";
import { login, verifyTwoFactor } from "@/lib/api/auth";
import { Alert } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Field } from "@/components/ui/field";

export default function LoginPage() {
  const t = useTranslations("auth");
  const router = useRouter();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [code, setCode] = useState("");
  const [needs2fa, setNeeds2fa] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  async function onSubmit(event: FormEvent) {
    event.preventDefault();
    setLoading(true);
    setError(null);

    try {
      if (needs2fa) {
        await verifyTwoFactor(email, code);
        router.replace("/");
        return;
      }

      const res = await login(email, password);
      if ("two_factor_required" in res) {
        setNeeds2fa(true);
      } else {
        router.replace("/");
      }
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("genericError"));
    } finally {
      setLoading(false);
    }
  }

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <h2 className="text-xl font-semibold text-slate-900 dark:text-slate-100">{t("login")}</h2>

      {error ? <Alert>{error}</Alert> : null}

      {needs2fa ? (
        <>
          <p className="text-sm text-slate-600 dark:text-slate-400">{t("twoFactorHint")}</p>
          <Field
            label={t("twoFactorCode")}
            name="code"
            inputMode="numeric"
            autoComplete="one-time-code"
            value={code}
            onChange={(e) => setCode(e.target.value)}
            required
          />
        </>
      ) : (
        <>
          <Field
            label={t("email")}
            name="email"
            type="email"
            autoComplete="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />
          <Field
            label={t("password")}
            name="password"
            type="password"
            autoComplete="current-password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
        </>
      )}

      <Button type="submit" disabled={loading} className="w-full">
        {loading ? t("signingIn") : needs2fa ? t("verify") : t("login")}
      </Button>

      <div className="flex justify-between text-sm">
        <Link href="/forgot-password" className="text-slate-600 hover:underline dark:text-slate-400">
          {t("forgotPassword")}
        </Link>
        <Link href="/register" className="text-slate-600 hover:underline dark:text-slate-400">
          {t("noAccount")}
        </Link>
      </div>
    </form>
  );
}
