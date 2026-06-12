// Shared TypeScript types for the HRM domain.
// TODO: define Employee, Department, Position, Attendance, Leave, etc.

export type Id = number | string;

export interface PaginatedResponse<T> {
  data: T[];
  // TODO: meta { current_page, total, per_page, ... } per Laravel convention
}
