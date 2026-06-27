"use client";

import { type FormEvent, useState } from "react";
import { useTranslations } from "next-intl";
import { Link } from "@/i18n/navigation";
import { forgotPassword } from "@/lib/api/auth";
import { ApiError } from "@/lib/api/client";
import { Alert } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Field } from "@/components/ui/field";

export default function ForgotPasswordPage() {
  const t = useTranslations("auth");

  const [email, setEmail] = useState("");
  const [sent, setSent] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  async function onSubmit(event: FormEvent) {
    event.preventDefault();
    setLoading(true);
    setError(null);

    try {
      await forgotPassword(email);
      setSent(true);
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("genericError"));
    } finally {
      setLoading(false);
    }
  }

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <h2 className="text-xl font-semibold text-slate-900 dark:text-slate-100">
        {t("forgotPassword")}
      </h2>

      {error ? <Alert>{error}</Alert> : null}
      {sent ? <Alert variant="success">{t("resetLinkSent")}</Alert> : null}

      <p className="text-sm text-slate-600 dark:text-slate-400">{t("forgotHint")}</p>

      <Field
        label={t("email")}
        name="email"
        type="email"
        autoComplete="email"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
        required
      />

      <Button type="submit" disabled={loading} className="w-full">
        {loading ? t("signingIn") : t("sendResetLink")}
      </Button>

      <p className="text-center text-sm text-slate-600 dark:text-slate-400">
        <Link href="/login" className="hover:underline">
          {t("backToLogin")}
        </Link>
      </p>
    </form>
  );
}
