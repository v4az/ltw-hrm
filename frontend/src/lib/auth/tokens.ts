// Client-side token storage. Tokens are kept in cookies (readable by JS so the
// API client can attach the Bearer header, and by middleware if route guarding
// is later moved server-side). The access token is short-lived; the refresh
// token is used to mint a new pair when the access token expires.

const ACCESS_KEY = "hrm_access_token";
const REFRESH_KEY = "hrm_refresh_token";

const ACCESS_MAX_AGE = 60 * 60; // 1h, matches backend ACCESS_TTL_MINUTES
const REFRESH_MAX_AGE = 60 * 60 * 24 * 30; // 30d, matches backend REFRESH_TTL_DAYS

function setCookie(name: string, value: string, maxAge: number): void {
  document.cookie = `${name}=${encodeURIComponent(value)}; path=/; max-age=${maxAge}; samesite=lax`;
}

function getCookie(name: string): string | null {
  if (typeof document === "undefined") return null;
  const match = document.cookie.match(new RegExp(`(?:^|; )${name}=([^;]*)`));
  return match ? decodeURIComponent(match[1]) : null;
}

function deleteCookie(name: string): void {
  document.cookie = `${name}=; path=/; max-age=0`;
}

export interface TokenPair {
  token: string;
  refresh_token: string;
}

export function setTokens(pair: TokenPair): void {
  setCookie(ACCESS_KEY, pair.token, ACCESS_MAX_AGE);
  setCookie(REFRESH_KEY, pair.refresh_token, REFRESH_MAX_AGE);
}

export function clearTokens(): void {
  deleteCookie(ACCESS_KEY);
  deleteCookie(REFRESH_KEY);
}

export function getAccessToken(): string | null {
  return getCookie(ACCESS_KEY);
}

export function getRefreshToken(): string | null {
  return getCookie(REFRESH_KEY);
}
