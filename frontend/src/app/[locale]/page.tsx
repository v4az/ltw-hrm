import { redirect } from "@/i18n/navigation";

export default async function Index({
  params,
}: {
  params: Promise<{ locale: string }>;
}) {
  const { locale } = await params;
  // TODO: redirect based on auth state (login if anon, dashboard if authed)
  redirect({ href: "/login", locale });
}
