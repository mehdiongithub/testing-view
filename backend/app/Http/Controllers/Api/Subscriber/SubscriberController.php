<?php

namespace App\Http\Controllers\Api\Subscriber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class SubscriberController extends Controller
{
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user()->load(['country', 'state', 'city']);
 
        return response()->json([
            'user' => [
                'id'            => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'phone'         => $user->phone,
                'role'          => $user->role,
                'auth_provider' => $user->auth_provider,
                'is_active'     => $user->is_active,
                'country_id'    => $user->country_id,
                'state_id'      => $user->state_id,
                'city_id'       => $user->city_id,
                'created_at'    => $user->created_at,
            ],
        ]);
    }
 
    /**
     * PATCH /subscriber/profile
     * Update the authenticated user's own profile.
     *
     * Subscribers can update: name, phone, password, country/state/city.
     * They CANNOT change their own role or email (email change needs a
     * separate verification flow — add that when ready).
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();
 
        $validator = Validator::make($request->all(), [
            'name'             => 'sometimes|string|max:255',
            'phone'            => 'sometimes|nullable|string|max:255',
            'country_id'       => 'sometimes|nullable|exists:countries,id',
            'state_id'         => 'sometimes|nullable|exists:states,id',
            'city_id'          => 'sometimes|nullable|exists:cities,id',
            'current_password' => 'required_with:new_password|string',
            'new_password'     => 'sometimes|string|min:8|confirmed',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
 
        $data = $validator->validated();
 
        // Handle password change separately
        if (isset($data['new_password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return response()->json(['message' => 'Current password is incorrect.'], 422);
            }
            $data['password'] = Hash::make($data['new_password']);
        }
 
        // Strip fields not meant for the users table
        unset($data['current_password'], $data['new_password'], $data['new_password_confirmation']);
 
        $user->update($data);
 
        return response()->json([
            'message' => 'Profile updated successfully.',
            'user'    => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone,
                'country_id' => $user->country_id,
                'state_id'   => $user->state_id,
                'city_id'    => $user->city_id,
            ],
        ]);
    }
 
  
}
