// TODO: implement fetch wrapper with Sanctum token + CSRF cookie handling.
// Pattern: csrfCookie() before mutating requests, then fetch with credentials: "include".
// Token should live in an httpOnly cookie set by the backend, NOT localStorage.

export const api = {
  // TODO: get<T>(path: string): Promise<T>
  // TODO: post<T, B>(path: string, body: B): Promise<T>
  // TODO: put<T, B>(path: string, body: B): Promise<T>
  // TODO: delete<T>(path: string): Promise<T>
};
