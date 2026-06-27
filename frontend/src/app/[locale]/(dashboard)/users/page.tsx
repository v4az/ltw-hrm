"use client";

import { type FormEvent, useCallback, useEffect, useState } from "react";
import { useTranslations } from "next-intl";
import { ApiError } from "@/lib/api/client";
import {
  activateUser,
  createUser,
  deactivateUser,
  deleteUser,
  listUsers,
} from "@/lib/api/users";
import type { User } from "@/lib/types";
import { Alert } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Field } from "@/components/ui/field";

const EMPTY_FORM = {
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
};

export default function UsersPage() {
  const t = useTranslations("admin");
  const tModules = useTranslations("modules");

  const [users, setUsers] = useState<User[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [showForm, setShowForm] = useState(false);
  const [form, setForm] = useState(EMPTY_FORM);
  const [submitting, setSubmitting] = useState(false);

  const load = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const res = await listUsers();
      setUsers(res.data);
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("loadError"));
    } finally {
      setLoading(false);
    }
  }, [t]);

  useEffect(() => {
    load();
  }, [load]);

  function update(key: keyof typeof form) {
    return (e: React.ChangeEvent<HTMLInputElement>) =>
      setForm((f) => ({ ...f, [key]: e.target.value }));
  }

  async function onCreate(event: FormEvent) {
    event.preventDefault();
    setSubmitting(true);
    setError(null);
    try {
      await createUser(form);
      setForm(EMPTY_FORM);
      setShowForm(false);
      await load();
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("saveError"));
    } finally {
      setSubmitting(false);
    }
  }

  async function onToggleActive(user: User) {
    try {
      if (user.is_active) {
        await deactivateUser(user.id);
      } else {
        await activateUser(user.id);
      }
      await load();
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("saveError"));
    }
  }

  async function onDelete(user: User) {
    try {
      await deleteUser(user.id);
      await load();
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("saveError"));
    }
  }

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <h1 className="text-xl font-semibold text-slate-900 dark:text-slate-100">
          {tModules("users")}
        </h1>
        <Button onClick={() => setShowForm((v) => !v)}>{t("addUser")}</Button>
      </div>

      {error ? <Alert>{error}</Alert> : null}

      {showForm ? (
        <form
          onSubmit={onCreate}
          className="grid gap-3 rounded-lg border border-slate-200 p-4 sm:grid-cols-2 dark:border-slate-800"
        >
          <Field label={t("name")} name="name" value={form.name} onChange={update("name")} required />
          <Field
            label={t("email")}
            name="email"
            type="email"
            value={form.email}
            onChange={update("email")}
            required
          />
          <Field
            label={t("password")}
            name="password"
            type="password"
            value={form.password}
            onChange={update("password")}
            required
          />
          <Field
            label={t("confirmPassword")}
            name="password_confirmation"
            type="password"
            value={form.password_confirmation}
            onChange={update("password_confirmation")}
            required
          />
          <div className="sm:col-span-2">
            <Button type="submit" disabled={submitting}>
              {t("create")}
            </Button>
          </div>
        </form>
      ) : null}

      <div className="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800">
        <table className="w-full text-left text-sm">
          <thead className="bg-slate-50 text-slate-600 dark:bg-slate-900 dark:text-slate-400">
            <tr>
              <th className="px-4 py-2 font-medium">{t("name")}</th>
              <th className="px-4 py-2 font-medium">{t("email")}</th>
              <th className="px-4 py-2 font-medium">{t("roles")}</th>
              <th className="px-4 py-2 font-medium">{t("status")}</th>
              <th className="px-4 py-2 text-right font-medium">{t("actions")}</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
            {loading ? (
              <tr>
                <td colSpan={5} className="px-4 py-6 text-center text-slate-500">
                  {t("loading")}
                </td>
              </tr>
            ) : users.length === 0 ? (
              <tr>
                <td colSpan={5} className="px-4 py-6 text-center text-slate-500">
                  {t("noUsers")}
                </td>
              </tr>
            ) : (
              users.map((user) => (
                <tr key={user.id} className="text-slate-800 dark:text-slate-200">
                  <td className="px-4 py-2">{user.name}</td>
                  <td className="px-4 py-2">{user.email}</td>
                  <td className="px-4 py-2">{user.roles?.join(", ") || "—"}</td>
                  <td className="px-4 py-2">
                    <span
                      className={
                        user.is_active
                          ? "rounded-full bg-green-100 px-2 py-0.5 text-xs text-green-700 dark:bg-green-950 dark:text-green-300"
                          : "rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-400"
                      }
                    >
                      {user.is_active ? t("active") : t("inactive")}
                    </span>
                  </td>
                  <td className="px-4 py-2">
                    <div className="flex justify-end gap-2">
                      <Button variant="secondary" onClick={() => onToggleActive(user)}>
                        {user.is_active ? t("deactivate") : t("activate")}
                      </Button>
                      <Button variant="danger" onClick={() => onDelete(user)}>
                        {t("delete")}
                      </Button>
                    </div>
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>
    </div>
  );
}
