// API endpoint constants — keep in sync with backend routes/api/v1/* and docs/api-routes.csv.

export const API_BASE =
  process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:8000/api/v1";

// TODO: typed route builders, e.g.
// export const employees = {
//   list: () => `${API_BASE}/employees`,
//   show: (id: number | string) => `${API_BASE}/employees/${id}`,
// };
