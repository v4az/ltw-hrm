// API endpoint constants — keep in sync with backend routes/api/v1/* and docs/api-routes.csv.

import type { Id } from "@/lib/types";

export const API_BASE =
  process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:8000/api/v1";

export const endpoints = {
  auth: {
    register: "/auth/register",
    login: "/auth/login",
    logout: "/auth/logout",
    refresh: "/auth/refresh",
    forgotPassword: "/auth/forgot-password",
    resetPassword: "/auth/reset-password",
    changePassword: "/auth/change-password",
    verify2fa: "/auth/2fa/verify",
    me: "/auth/me",
  },
  users: {
    list: "/users",
    show: (id: Id) => `/users/${id}`,
    activate: (id: Id) => `/users/${id}/activate`,
    deactivate: (id: Id) => `/users/${id}/deactivate`,
  },
  roles: {
    list: "/roles",
    show: (id: Id) => `/roles/${id}`,
  },
} as const;
