import type { Id, PaginatedResponse, User } from "@/lib/types";
import { api } from "./client";
import { endpoints } from "./endpoints";

export interface CreateUserPayload {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
  roles?: string[];
}

export function listUsers(params?: { search?: string; page?: number }): Promise<PaginatedResponse<User>> {
  const query = new URLSearchParams();
  if (params?.search) query.set("search", params.search);
  if (params?.page) query.set("page", String(params.page));
  const qs = query.toString();

  return api.get(`${endpoints.users.list}${qs ? `?${qs}` : ""}`);
}

export function createUser(payload: CreateUserPayload): Promise<{ data: User }> {
  return api.post(endpoints.users.list, payload);
}

export function activateUser(id: Id): Promise<{ data: User }> {
  return api.patch(endpoints.users.activate(id));
}

export function deactivateUser(id: Id): Promise<{ data: User }> {
  return api.patch(endpoints.users.deactivate(id));
}

export function deleteUser(id: Id): Promise<{ message: string }> {
  return api.del(endpoints.users.show(id));
}
