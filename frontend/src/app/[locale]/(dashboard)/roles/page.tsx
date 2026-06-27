"use client";

import { type FormEvent, useCallback, useEffect, useState } from "react";
import { useTranslations } from "next-intl";
import { ApiError } from "@/lib/api/client";
import { createRole, listRoles } from "@/lib/api/roles";
import type { Role } from "@/lib/types";
import { Alert } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Field } from "@/components/ui/field";

export default function RolesPage() {
  const t = useTranslations("admin");
  const tModules = useTranslations("modules");

  const [roles, setRoles] = useState<Role[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [showForm, setShowForm] = useState(false);
  const [name, setName] = useState("");
  const [submitting, setSubmitting] = useState(false);

  const load = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const res = await listRoles();
      setRoles(res.data);
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("loadError"));
    } finally {
      setLoading(false);
    }
  }, [t]);

  useEffect(() => {
    load();
  }, [load]);

  async function onCreate(event: FormEvent) {
    event.preventDefault();
    setSubmitting(true);
    setError(null);
    try {
      await createRole({ name });
      setName("");
      setShowForm(false);
      await load();
    } catch (err) {
      setError(err instanceof ApiError ? err.message : t("saveError"));
    } finally {
      setSubmitting(false);
    }
  }

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <h1 className="text-xl font-semibold text-slate-900 dark:text-slate-100">
          {tModules("roles")}
        </h1>
        <Button onClick={() => setShowForm((v) => !v)}>{t("addRole")}</Button>
      </div>

      {error ? <Alert>{error}</Alert> : null}

      {showForm ? (
        <form
          onSubmit={onCreate}
          className="flex items-end gap-3 rounded-lg border border-slate-200 p-4 dark:border-slate-800"
        >
          <div className="flex-1">
            <Field
              label={t("roleName")}
              name="name"
              value={name}
              onChange={(e) => setName(e.target.value)}
              required
            />
          </div>
          <Button type="submit" disabled={submitting}>
            {t("create")}
          </Button>
        </form>
      ) : null}

      <div className="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800">
        <table className="w-full text-left text-sm">
          <thead className="bg-slate-50 text-slate-600 dark:bg-slate-900 dark:text-slate-400">
            <tr>
              <th className="px-4 py-2 font-medium">{t("name")}</th>
              <th className="px-4 py-2 font-medium">{t("permissions")}</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
            {loading ? (
              <tr>
                <td colSpan={2} className="px-4 py-6 text-center text-slate-500">
                  {t("loading")}
                </td>
              </tr>
            ) : roles.length === 0 ? (
              <tr>
                <td colSpan={2} className="px-4 py-6 text-center text-slate-500">
                  {t("noRoles")}
                </td>
              </tr>
            ) : (
              roles.map((role) => (
                <tr key={role.id} className="text-slate-800 dark:text-slate-200">
                  <td className="px-4 py-2 font-medium">{role.name}</td>
                  <td className="px-4 py-2 text-slate-600 dark:text-slate-400">
                    {role.permissions?.length ? role.permissions.join(", ") : "—"}
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
