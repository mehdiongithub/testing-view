<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}
 
    /**
     * Register a new user (default role: website_subscriber)
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:255',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
 
        $user = $this->authService->registerUser($validator->validated());
 
        $token = $user->createToken('auth_token', $this->authService->getAbilities($user->role))->plainTextToken;
 
        return response()->json([
            'message' => 'Registration successful',
            'user'    => $this->authService->formatUser($user),
            'token'   => $token,
        ], 201);
    }
 
    /**
     * Login with email & password
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
 
        $user = User::where('email', $request->email)->whereNull('deleted_at')->first();
 
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
 
        if (!$user->is_active) {
            return response()->json(['message' => 'Account is deactivated. Contact support.'], 403);
        }
 
        // Revoke old tokens to enforce single-session (remove this line for multi-device)
        $user->tokens()->delete();
 
        $token = $user->createToken('auth_token', $this->authService->getAbilities($user->role))->plainTextToken;
 
        return response()->json([
            'message' => 'Login successful',
            'user'    => $this->authService->formatUser($user),
            'token'   => $token,
        ]);
    }
 
    /**
     * Google / Facebook OAuth callback
     */
    public function socialLogin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'provider'    => 'required|in:google,facebook',
            'provider_id' => 'required|string',
            'name'        => 'required|string',
            'email'       => 'required|email',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
 
        $user = $this->authService->findOrCreateSocialUser($validator->validated());
 
        if (!$user->is_active) {
            return response()->json(['message' => 'Account is deactivated.'], 403);
        }
 
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', $this->authService->getAbilities($user->role))->plainTextToken;
 
        return response()->json([
            'message' => 'Social login successful',
            'user'    => $this->authService->formatUser($user),
            'token'   => $token,
        ]);
    }
 
    /**
     * Get authenticated user profile
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $this->authService->formatUser($request->user()),
        ]);
    }
 
    /**
     * Logout — revoke current token
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
 
        return response()->json(['message' => 'Logged out successfully']);
    }
 
    /**
     * Logout from all devices
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
 
        return response()->json(['message' => 'Logged out from all devices']);
    }

}
