<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * List users with search, role and status filters plus pagination.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = User::query()->with('roles');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->query('role'));
        }

        if (! is_null($request->query('is_active'))) {
            $query->where('is_active', filter_var($request->query('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        return UserResource::collection(
            $query->latest()->paginate($request->integer('per_page', 15))
        );
    }

    /**
     * Create a new user account.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create($data);

        if (! empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return (new UserResource($user->load('roles')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Get a single user with roles.
     */
    public function show(string $id): UserResource
    {
        return new UserResource(User::with('roles')->findOrFail($id));
    }

    /**
     * Update a user's details and (optionally) roles.
     */
    public function update(UpdateUserRequest $request, string $id): UserResource
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        $user->update(collect($data)->except('roles')->toArray());

        if (array_key_exists('roles', $data)) {
            $user->syncRoles($data['roles'] ?? []);
        }

        return new UserResource($user->load('roles'));
    }

    /**
     * Soft delete a user account.
     */
    public function destroy(string $id): JsonResponse
    {
        User::findOrFail($id)->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

    /**
     * Activate a user account.
     */
    public function activate(string $id): UserResource
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => true]);

        return new UserResource($user->load('roles'));
    }

    /**
     * Deactivate a user account and revoke its tokens.
     */
    public function deactivate(string $id): UserResource
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => false]);
        $user->tokens()->delete();

        return new UserResource($user->load('roles'));
    }

    /**
     * Admin force-reset of a user's password.
     */
    public function resetPassword(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user = User::findOrFail($id);
        $generated = ! $request->filled('password');
        $password = $generated ? Str::password(16) : $request->input('password');

        $user->update(['password' => $password]);
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Password reset successfully.',
            // Only returned when the server generated the password.
            'password' => $generated ? $password : null,
        ]);
    }

    /**
     * List a user's active sessions (personal access tokens).
     */
    public function sessions(string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        return response()->json([
            'data' => $user->tokens()->get(['id', 'name', 'last_used_at', 'created_at']),
        ]);
    }

    /**
     * Revoke a specific session of a user.
     */
    public function revokeSession(string $id, string $sessionId): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->tokens()->where('id', $sessionId)->delete();

        return response()->json(['message' => 'Session revoked successfully.']);
    }
}
