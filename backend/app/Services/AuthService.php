<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Sanctum token abilities mapped to each role.
     * These drive server-side permission checks inside controllers.
     */
    public function getAbilities(string $role): array
    {
        return match ($role) {
            'website_admin' => ['*'],   // wildcard = full access
            'website_worker' => [
                'read:dashboard',
                'read:orders',
                'write:orders',
                'read:products',
                'write:products',
                'read:users',
            ],
            'website_subscriber' => [
                'read:profile',
                'write:profile',
                'read:orders',
            ],
            default => ['read:profile'],
        };
    }

    public function registerUser(array $data): User
    {
        return User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'phone'         => $data['phone'] ?? null,
            'role'          => 'website_subscriber',
            'auth_provider' => 'local',
            'is_active'     => true,
        ]);
    }

    public function findOrCreateSocialUser(array $data): User
    {
        return User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name'          => $data['name'],
                'auth_provider' => $data['provider'],
                'provider_id'   => $data['provider_id'],
                'role'          => 'website_subscriber',
                'is_active'     => true,
            ]
        );
    }

    public function formatUser(User $user): array
    {
        return [
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'phone'         => $user->phone,
            'role'          => $user->role,
            'is_active'     => $user->is_active,
            'auth_provider' => $user->auth_provider,
            'country_id'    => $user->country_id,
            'state_id'      => $user->state_id,
            'city_id'       => $user->city_id,
            'created_at'    => $user->created_at,
        ];
    }
}