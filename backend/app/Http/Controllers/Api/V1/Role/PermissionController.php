<?php

namespace App\Http\Controllers\Api\V1\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * List all permissions.
     */
    public function index(): AnonymousResourceCollection
    {
        return PermissionResource::collection(Permission::all());
    }

    /**
     * Create a new permission.
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        $permission = Permission::create(['name' => $request->name, 'guard_name' => 'web']);

        return (new PermissionResource($permission))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show a single permission.
     */
    public function show(string $id): PermissionResource
    {
        return new PermissionResource(Permission::findOrFail($id));
    }

    /**
     * Update a permission's name.
     */
    public function update(UpdatePermissionRequest $request, string $id): PermissionResource
    {
        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name]);

        return new PermissionResource($permission);
    }

    /**
     * Delete a permission.
     */
    public function destroy(string $id): JsonResponse
    {
        Permission::findOrFail($id)->delete();

        return response()->json(['message' => 'Permission deleted successfully.']);
    }
}
