<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\TwoFactorVerifyRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\TwoFactorService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    private const ACCESS_TTL_MINUTES = 60;

    private const REFRESH_TTL_DAYS = 30;

    public function __construct(private readonly TwoFactorService $twoFactor) {}

    /**
     * Issue a short-lived access token + long-lived refresh token pair.
     * Both share a "family" id (encoded in the token name) so a single
     * session can be rotated or revoked as a unit.
     *
     * @return array<string, mixed>
     */
    private function issueTokens(User $user): array
    {
        $family = Str::uuid()->toString();

        $access = $user->createToken(
            "access:{$family}",
            ['access'],
            now()->addMinutes(self::ACCESS_TTL_MINUTES),
        )->plainTextToken;

        $refresh = $user->createToken(
            "refresh:{$family}",
            ['refresh'],
            now()->addDays(self::REFRESH_TTL_DAYS),
        )->plainTextToken;

        return [
            'token' => $access,
            'refresh_token' => $refresh,
            'token_type' => 'Bearer',
            'expires_in' => self::ACCESS_TTL_MINUTES * 60,
        ];
    }

    /**
     * Delete every token belonging to the same session family.
     */
    private function revokeFamily(User $user, string $tokenName): void
    {
        $familyId = str_contains($tokenName, ':') ? explode(':', $tokenName, 2)[1] : null;

        if ($familyId) {
            $user->tokens()->where('name', 'like', "%:{$familyId}")->delete();
        }
    }

    /**
     * Register a new user account and issue an access token.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        if (Role::where('name', 'employee')->where('guard_name', 'web')->exists()) {
            $user->assignRole('employee');
        }

        event(new Registered($user));

        return (new UserResource($user->load('roles')))
            ->additional($this->issueTokens($user))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Authenticate credentials and issue an access token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        if (! $user->is_active) {
            return response()->json(['message' => 'Account is deactivated.'], 403);
        }

        if ($user->two_factor_enabled) {
            return response()->json([
                'two_factor_required' => true,
                'message' => 'Two-factor authentication code required.',
            ]);
        }

        return (new UserResource($user->load('roles')))
            ->additional($this->issueTokens($user))
            ->response();
    }

    /**
     * Revoke the current session (its access + refresh token).
     */
    public function logout(Request $request): JsonResponse
    {
        $this->revokeFamily($request->user(), $request->user()->currentAccessToken()->name);

        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * Exchange a refresh token for a fresh access + refresh token pair.
     * The presented refresh token's whole family is rotated out.
     */
    public function refresh(Request $request): JsonResponse
    {
        $refreshToken = PersonalAccessToken::findToken((string) $request->bearerToken());

        if (! $refreshToken
            || ! $refreshToken->can('refresh')
            || ($refreshToken->expires_at && $refreshToken->expires_at->isPast())) {
            return response()->json(['message' => 'Invalid or expired refresh token.'], 401);
        }

        $user = $refreshToken->tokenable;
        $this->revokeFamily($user, $refreshToken->name);

        return response()->json($this->issueTokens($user));
    }

    /**
     * Send a password reset link to the user.
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink($request->only('email'));

        return response()->json(
            ['message' => __($status)],
            $status === Password::RESET_LINK_SENT ? 200 : 422
        );
    }

    /**
     * Reset the password using a reset token.
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill(['password' => Hash::make($password)])->save();
                $user->tokens()->delete();
            }
        );

        return response()->json(
            ['message' => __($status)],
            $status === Password::PASSWORD_RESET ? 200 : 422
        );
    }

    /**
     * Verify a user's email address using the id + hash signature.
     */
    public function verifyEmail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required'],
            'hash' => ['required', 'string'],
        ]);

        $user = User::findOrFail($validated['id']);

        if (! hash_equals(sha1($user->getEmailForVerification()), $validated['hash'])) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json(['message' => 'Email verified successfully.']);
    }

    /**
     * Resend the email verification notification.
     */
    public function resendVerification(Request $request): JsonResponse
    {
        $validated = $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $validated['email'])->first();

        if ($user && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return response()->json([
            'message' => 'If the account exists and is unverified, a verification link has been sent.',
        ]);
    }

    /**
     * Change the authenticated user's password (requires the current one).
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        $user->update(['password' => $request->password]);

        // Invalidate every existing session and hand back a fresh token pair.
        $user->tokens()->delete();

        return response()->json(array_merge(
            ['message' => 'Password changed successfully.'],
            $this->issueTokens($user),
        ));
    }

    /**
     * Get the current authenticated user with roles and permissions.
     */
    public function me(Request $request): UserResource
    {
        return new UserResource($request->user()->load('roles'));
    }

    /**
     * Begin 2FA enrollment: generate and store a secret, return the otpauth URI.
     */
    public function enable2fa(Request $request): JsonResponse
    {
        $user = $request->user();
        $secret = $this->twoFactor->generateSecret();

        $user->forceFill([
            'two_factor_secret' => $secret,
            'two_factor_enabled' => false,
            'two_factor_confirmed_at' => null,
        ])->save();

        return response()->json([
            'secret' => $secret,
            'otpauth_uri' => $this->twoFactor->otpauthUri(config('app.name'), $user->email, $secret),
            'message' => 'Scan the secret in your authenticator app, then confirm a code via POST /auth/2fa/verify.',
        ]);
    }

    /**
     * Verify a 2FA code — confirms enrollment, or completes a 2FA login.
     */
    public function verify2fa(TwoFactorVerifyRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! $user->two_factor_secret) {
            throw ValidationException::withMessages([
                'code' => ['Two-factor authentication is not set up for this account.'],
            ]);
        }

        if (! $this->twoFactor->verify($user->two_factor_secret, $request->code)) {
            throw ValidationException::withMessages([
                'code' => ['The provided authentication code is invalid.'],
            ]);
        }

        // First successful code confirms enrollment.
        if (! $user->two_factor_enabled) {
            $user->forceFill([
                'two_factor_enabled' => true,
                'two_factor_confirmed_at' => now(),
            ])->save();

            return response()->json([
                'two_factor_enabled' => true,
                'message' => 'Two-factor authentication enabled.',
            ]);
        }

        // Otherwise this completes a login that was paused for 2FA.
        return (new UserResource($user->load('roles')))
            ->additional($this->issueTokens($user))
            ->response();
    }

    /**
     * Disable 2FA for the authenticated user.
     */
    public function disable2fa(Request $request): JsonResponse
    {
        $request->user()->forceFill([
            'two_factor_secret' => null,
            'two_factor_enabled' => false,
            'two_factor_confirmed_at' => null,
        ])->save();

        return response()->json(['message' => 'Two-factor authentication disabled.']);
    }
}
