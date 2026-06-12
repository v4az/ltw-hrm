import { useTranslations } from "next-intl";

export default function Page() {
  const t = useTranslations("modules");
  return (
    <div>
      <h1 className="text-2xl font-bold text-slate-900 dark:text-slate-100">
        {t("dashboard")}
      </h1>
      <p className="mt-2 text-slate-600 dark:text-slate-400">
        {/* TODO: dashboard metrics */}
      </p>
    </div>
  );
}
