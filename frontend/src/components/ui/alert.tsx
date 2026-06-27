interface AlertProps {
  variant?: "error" | "success";
  children: React.ReactNode;
}

const VARIANTS: Record<string, string> = {
  error:
    "border-red-200 bg-red-50 text-red-700 dark:border-red-900 dark:bg-red-950 dark:text-red-300",
  success:
    "border-green-200 bg-green-50 text-green-700 dark:border-green-900 dark:bg-green-950 dark:text-green-300",
};

export function Alert({ variant = "error", children }: AlertProps) {
  return (
    <div className={`rounded-md border px-3 py-2 text-sm ${VARIANTS[variant]}`}>{children}</div>
  );
}
