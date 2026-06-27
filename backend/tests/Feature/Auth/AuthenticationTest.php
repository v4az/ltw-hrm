<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Services\Auth\TwoFactorService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_user_can_register_and_receive_a_token(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['data' => ['id', 'name', 'email'], 'token']);

        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
        $this->assertTrue(User::where('email', 'jane@example.com')->first()->hasRole('employee'));
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'Password123!']);

        $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ])->assertOk()->assertJsonStructure(['data' => ['id', 'email'], 'token']);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'Password123!']);

        $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertStatus(422);
    }

    public function test_deactivated_user_cannot_login(): void
    {
        $user = User::factory()->create(['password' => 'Password123!', 'is_active' => false]);

        $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ])->assertStatus(403);
    }

    public function test_me_returns_the_authenticated_user(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['access']);

        $this->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('data.email', $user->email);
    }

    public function test_user_can_change_password(): void
    {
        $user = User::factory()->create(['password' => 'OldPassword123!']);
        Sanctum::actingAs($user, ['access']);

        $this->postJson('/api/v1/auth/change-password', [
            'current_password' => 'OldPassword123!',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ])->assertOk();

        $this->assertTrue(
            \Illuminate\Support\Facades\Hash::check('NewPassword123!', $user->fresh()->password)
        );
    }

    public function test_login_with_2fa_enabled_requires_a_code(): void
    {
        $secret = app(TwoFactorService::class)->generateSecret();
        $user = User::factory()->create([
            'password' => 'Password123!',
            'two_factor_enabled' => true,
            'two_factor_secret' => $secret,
        ]);

        $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ])->assertOk()->assertJsonPath('two_factor_required', true);
    }

    public function test_login_returns_an_access_and_refresh_token_pair(): void
    {
        $user = User::factory()->create(['password' => 'Password123!']);

        $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ])->assertOk()->assertJsonStructure([
            'data', 'token', 'refresh_token', 'token_type', 'expires_in',
        ]);
    }

    public function test_refresh_token_exchanges_for_a_new_pair(): void
    {
        $user = User::factory()->create(['password' => 'Password123!']);
        $login = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ])->json();

        $this->withToken($login['refresh_token'])
            ->postJson('/api/v1/auth/refresh')
            ->assertOk()
            ->assertJsonStructure(['token', 'refresh_token']);
    }

    public function test_access_token_is_accepted_on_protected_endpoints(): void
    {
        $user = User::factory()->create(['password' => 'Password123!']);
        $login = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ])->json();

        $this->withToken($login['token'])
            ->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('data.email', $user->email);
    }

    public function test_refresh_token_is_rejected_on_protected_endpoints(): void
    {
        $user = User::factory()->create(['password' => 'Password123!']);
        $login = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ])->json();

        // A refresh-scoped token must not be usable as an access token.
        $this->withToken($login['refresh_token'])
            ->getJson('/api/v1/auth/me')
            ->assertForbidden();
    }
}
