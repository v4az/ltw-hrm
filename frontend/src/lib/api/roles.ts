import type { Role } from "@/lib/types";
import { api } from "./client";
import { endpoints } from "./endpoints";

export interface CreateRolePayload {
  name: string;
  permissions?: string[];
}

export function listRoles(): Promise<{ data: Role[] }> {
  return api.get(endpoints.roles.list);
}

export function createRole(payload: CreateRolePayload): Promise<{ data: Role }> {
  return api.post(endpoints.roles.list, payload);
}
