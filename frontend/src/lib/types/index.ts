// Shared TypeScript types for the HRM domain.

export type Id = number | string;

export interface PaginationMeta {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
}

export interface PaginatedResponse<T> {
  data: T[];
  meta: PaginationMeta;
}

export interface User {
  id: number;
  name: string;
  email: string;
  is_active: boolean;
  two_factor_enabled?: boolean;
  email_verified_at?: string | null;
  roles?: string[];
  permissions?: string[];
  created_at?: string;
  updated_at?: string;
}

export interface Role {
  id: number;
  name: string;
  guard_name?: string;
  permissions?: string[];
}

export interface AuthTokens {
  token: string;
  refresh_token: string;
  token_type: string;
  expires_in: number;
}

export interface LoginResponse extends AuthTokens {
  data: User;
}

export interface TwoFactorRequired {
  two_factor_required: true;
  message: string;
}
