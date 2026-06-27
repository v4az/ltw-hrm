import { clearTokens, setTokens } from "@/lib/auth/tokens";
import type { LoginResponse, TwoFactorRequired, User } from "@/lib/types";
import { api } from "./client";
import { endpoints } from "./endpoints";

export interface RegisterPayload {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export interface ResetPasswordPayload {
  token: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export async function login(
  email: string,
  password: string,
): Promise<LoginResponse | TwoFactorRequired> {
  const res = await api.post<LoginResponse | TwoFactorRequired>(
    endpoints.auth.login,
    { email, password },
    false,
  );
  if ("token" in res) setTokens(res);
  return res;
}

export async function verifyTwoFactor(email: string, code: string): Promise<LoginResponse> {
  const res = await api.post<LoginResponse>(endpoints.auth.verify2fa, { email, code }, false);
  setTokens(res);
  return res;
}

export async function register(payload: RegisterPayload): Promise<LoginResponse> {
  const res = await api.post<LoginResponse>(endpoints.auth.register, payload, false);
  setTokens(res);
  return res;
}

export function forgotPassword(email: string): Promise<{ message: string }> {
  return api.post(endpoints.auth.forgotPassword, { email }, false);
}

export function resetPassword(payload: ResetPasswordPayload): Promise<{ message: string }> {
  return api.post(endpoints.auth.resetPassword, payload, false);
}

export function me(): Promise<{ data: User }> {
  return api.get(endpoints.auth.me);
}

export async function logout(): Promise<void> {
  try {
    await api.post(endpoints.auth.logout, {});
  } catch {
    // Even if the request fails, drop local tokens.
  } finally {
    clearTokens();
  }
}
