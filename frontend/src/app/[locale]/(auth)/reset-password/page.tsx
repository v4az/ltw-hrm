import { useTranslations } from "next-intl";

export default function Page() {
  const t = useTranslations("auth");
  return (
    <div>
      <h2 className="text-xl font-semibold text-slate-900 dark:text-slate-100">
        {t("resetPassword")}
      </h2>
      {/* TODO: form */}
    </div>
  );
}
