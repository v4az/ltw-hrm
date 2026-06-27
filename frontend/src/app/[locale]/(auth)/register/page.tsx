"use client";

import { type FormEvent, useState } from "react";
import { useTranslations } from "next-intl";
import { Link, useRouter } from "@/i18n/navigation";
import { register } from "@/lib/api/auth";
import { ApiError } from "@/lib/api/client";
import { Alert } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Field } from "@/components/ui/field";

export default function RegisterPage() {
  const t = useTranslations("auth");
  const router = useRouter();

  const [form, setForm] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  function update(key: keyof typeof form) {
    return (e: React.ChangeEvent<HTMLInputElement>) =>
      setForm((f) => ({ ...f, [key]: e.target.value }));
  }

  async function onSubmit(event: FormEvent) {
    event.preventDefault();
    setLoading(true);
    setError(null);

    try {
      await register(form);
      router.replace("/");
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("genericError"));
    } finally {
      setLoading(false);
    }
  }

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <h2 className="text-xl font-semibold text-slate-900 dark:text-slate-100">{t("register")}</h2>

      {error ? <Alert>{error}</Alert> : null}

      <Field label={t("name")} name="name" value={form.name} onChange={update("name")} required />
      <Field
        label={t("email")}
        name="email"
        type="email"
        autoComplete="email"
        value={form.email}
        onChange={update("email")}
        required
      />
      <Field
        label={t("password")}
        name="password"
        type="password"
        autoComplete="new-password"
        value={form.password}
        onChange={update("password")}
        required
      />
      <Field
        label={t("confirmPassword")}
        name="password_confirmation"
        type="password"
        autoComplete="new-password"
        value={form.password_confirmation}
        onChange={update("password_confirmation")}
        required
      />

      <Button type="submit" disabled={loading} className="w-full">
        {loading ? t("signingIn") : t("createAccount")}
      </Button>

      <p className="text-center text-sm text-slate-600 dark:text-slate-400">
        <Link href="/login" className="hover:underline">
          {t("haveAccount")}
        </Link>
      </p>
    </form>
  );
}
