<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        Sanctum::actingAs($admin, ['access']);

        return $admin;
    }

    public function test_admin_can_list_users(): void
    {
        $this->actingAsAdmin();
        User::factory()->count(3)->create();

        $this->getJson('/api/v1/users')
            ->assertOk()
            ->assertJsonStructure(['data', 'meta', 'links']);
    }

    public function test_admin_can_create_a_user_with_roles(): void
    {
        $this->actingAsAdmin();

        $this->postJson('/api/v1/users', [
            'name' => 'New Hire',
            'email' => 'newhire@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'roles' => ['hr'],
        ])->assertCreated()->assertJsonPath('data.roles.0', 'hr');

        $this->assertDatabaseHas('users', ['email' => 'newhire@example.com']);
    }

    public function test_admin_can_deactivate_a_user(): void
    {
        $this->actingAsAdmin();
        $user = User::factory()->create(['is_active' => true]);

        $this->patchJson("/api/v1/users/{$user->id}/deactivate")
            ->assertOk()
            ->assertJsonPath('data.is_active', false);
    }

    public function test_admin_can_soft_delete_a_user(): void
    {
        $this->actingAsAdmin();
        $user = User::factory()->create();

        $this->deleteJson("/api/v1/users/{$user->id}")->assertOk();
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_user_without_permission_is_forbidden(): void
    {
        $user = User::factory()->create();
        $user->assignRole('employee');
        Sanctum::actingAs($user, ['access']);

        $this->getJson('/api/v1/users')->assertForbidden();
    }

    public function test_guest_is_unauthenticated(): void
    {
        $this->getJson('/api/v1/users')->assertUnauthorized();
    }
}
