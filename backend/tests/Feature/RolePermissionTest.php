<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        Sanctum::actingAs($admin, ['access']);
    }

    public function test_can_list_roles(): void
    {
        $this->getJson('/api/v1/roles')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'name', 'permissions']]]);
    }

    public function test_can_create_role_with_permissions(): void
    {
        $this->postJson('/api/v1/roles', [
            'name' => 'auditor',
            'permissions' => ['users.view'],
        ])->assertCreated()->assertJsonPath('data.permissions.0', 'users.view');

        $this->assertDatabaseHas('roles', ['name' => 'auditor']);
    }

    public function test_can_attach_and_detach_permission(): void
    {
        $role = Role::create(['name' => 'auditor', 'guard_name' => 'web']);
        $permission = \Spatie\Permission\Models\Permission::where('name', 'users.view')->first();

        $this->postJson("/api/v1/roles/{$role->id}/permissions", [
            'permissions' => ['users.view'],
        ])->assertOk()->assertJsonPath('data.permissions.0', 'users.view');

        $this->deleteJson("/api/v1/roles/{$role->id}/permissions/{$permission->id}")
            ->assertOk();

        $this->assertEmpty($role->fresh()->permissions);
    }

    public function test_can_assign_role_to_users(): void
    {
        $role = Role::where('name', 'hr')->first();
        $users = User::factory()->count(2)->create();

        $this->postJson("/api/v1/roles/{$role->id}/assign", [
            'user_ids' => $users->pluck('id')->all(),
        ])->assertOk();

        foreach ($users as $user) {
            $this->assertTrue($user->fresh()->hasRole('hr'));
        }
    }

    public function test_can_crud_permissions(): void
    {
        $this->postJson('/api/v1/permissions', ['name' => 'reports.view'])
            ->assertCreated();

        $this->assertDatabaseHas('permissions', ['name' => 'reports.view']);
    }
}
