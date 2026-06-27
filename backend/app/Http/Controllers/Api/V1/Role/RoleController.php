<?php

namespace App\Http\Controllers\Api\V1\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\AssignRoleRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\SyncPermissionsRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * List all roles with their permissions.
     */
    public function index(): AnonymousResourceCollection
    {
        return RoleResource::collection(Role::with('permissions')->get());
    }

    /**
     * Create a new role, optionally with permissions.
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        // Pin to the web guard so role/permission guards match the seeded
        // permissions (the app default guard is sanctum).
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return (new RoleResource($role->load('permissions')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show a role with its permissions.
     */
    public function show(string $id): RoleResource
    {
        return new RoleResource(Role::with('permissions')->findOrFail($id));
    }

    /**
     * Update a role's name.
     */
    public function update(UpdateRoleRequest $request, string $id): RoleResource
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        return new RoleResource($role->load('permissions'));
    }

    /**
     * Delete a role.
     */
    public function destroy(string $id): JsonResponse
    {
        Role::findOrFail($id)->delete();

        return response()->json(['message' => 'Role deleted successfully.']);
    }

    /**
     * List the permissions assigned to a role.
     */
    public function permissions(string $id): AnonymousResourceCollection
    {
        $role = Role::with('permissions')->findOrFail($id);

        return PermissionResource::collection($role->permissions);
    }

    /**
     * Assign permissions to a role (added to any existing ones).
     */
    public function attachPermissions(SyncPermissionsRequest $request, string $id): RoleResource
    {
        $role = Role::findOrFail($id);
        $role->givePermissionTo($request->permissions);

        return new RoleResource($role->load('permissions'));
    }

    /**
     * Remove a single permission from a role.
     */
    public function detachPermission(string $id, string $permissionId): RoleResource
    {
        $role = Role::findOrFail($id);
        $permission = Permission::findOrFail($permissionId);
        $role->revokePermissionTo($permission);

        return new RoleResource($role->load('permissions'));
    }

    /**
     * Assign this role to one or more users.
     */
    public function assign(AssignRoleRequest $request, string $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        User::whereIn('id', $request->user_ids)->get()
            ->each(fn (User $user) => $user->assignRole($role->name));

        return response()->json([
            'message' => "Role '{$role->name}' assigned to ".count($request->user_ids).' user(s).',
        ]);
    }
}
