"use client";

import { type FormEvent, Suspense, useState } from "react";
import { useSearchParams } from "next/navigation";
import { useTranslations } from "next-intl";
import { Link, useRouter } from "@/i18n/navigation";
import { resetPassword } from "@/lib/api/auth";
import { ApiError } from "@/lib/api/client";
import { Alert } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Field } from "@/components/ui/field";

function ResetPasswordForm() {
  const t = useTranslations("auth");
  const router = useRouter();
  const params = useSearchParams();

  const [password, setPassword] = useState("");
  const [confirmation, setConfirmation] = useState("");
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  async function onSubmit(event: FormEvent) {
    event.preventDefault();
    setLoading(true);
    setError(null);

    try {
      await resetPassword({
        token: params.get("token") ?? "",
        email: params.get("email") ?? "",
        password,
        password_confirmation: confirmation,
      });
      router.replace("/login");
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("genericError"));
    } finally {
      setLoading(false);
    }
  }

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <h2 className="text-xl font-semibold text-slate-900 dark:text-slate-100">
        {t("resetPassword")}
      </h2>

      {error ? <Alert>{error}</Alert> : null}

      <p className="text-sm text-slate-600 dark:text-slate-400">{t("resetHint")}</p>

      <Field
        label={t("newPassword")}
        name="password"
        type="password"
        autoComplete="new-password"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
        required
      />
      <Field
        label={t("confirmPassword")}
        name="password_confirmation"
        type="password"
        autoComplete="new-password"
        value={confirmation}
        onChange={(e) => setConfirmation(e.target.value)}
        required
      />

      <Button type="submit" disabled={loading} className="w-full">
        {loading ? t("signingIn") : t("resetPassword")}
      </Button>

      <p className="text-center text-sm text-slate-600 dark:text-slate-400">
        <Link href="/login" className="hover:underline">
          {t("backToLogin")}
        </Link>
      </p>
    </form>
  );
}

export default function ResetPasswordPage() {
  return (
    <Suspense fallback={null}>
      <ResetPasswordForm />
    </Suspense>
  );
}
