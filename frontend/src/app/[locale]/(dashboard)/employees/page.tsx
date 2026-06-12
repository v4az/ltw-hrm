import { useTranslations } from "next-intl";

export default function Page() {
  const t = useTranslations("modules");
  return (
    <div>
      <h1 className="text-xl font-semibold text-slate-900 dark:text-slate-100">
        {t("employees")}
      </h1>
      {/* TODO: implement employees */}
    </div>
  );
}
