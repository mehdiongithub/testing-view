<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    public function dashboard(Request $request): JsonResponse
    {
        $stats = [
            'total_users'       => User::whereNull('deleted_at')->count(),
            'active_users'      => User::whereNull('deleted_at')->where('is_active', true)->count(),
            'inactive_users'    => User::whereNull('deleted_at')->where('is_active', false)->count(),
            'admins'            => User::whereNull('deleted_at')->where('role', 'website_admin')->count(),
            'workers'           => User::whereNull('deleted_at')->where('role', 'website_worker')->count(),
            'subscribers'       => User::whereNull('deleted_at')->where('role', 'website_subscriber')->count(),
            'new_this_month'    => User::whereNull('deleted_at')
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
        ];
 
        return response()->json([
            'message' => 'Admin dashboard',
            'stats'   => $stats,
        ]);
    }
 
    /**
     * GET /admin/users
     * Paginated + filterable user list.
     *
     * Query params:
     *   - search   : string  (name or email)
     *   - role     : string
     *   - is_active: 0|1
     *   - per_page : int (default 15)
     */
    public function listUsers(Request $request): JsonResponse
    {
        $query = User::whereNull('deleted_at')
                     ->select([
                         'id', 'name', 'email', 'phone', 'role',
                         'is_active', 'auth_provider', 'country_id',
                         'state_id', 'city_id', 'created_at',
                     ]);
 
        // Search by name or email
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
 
        // Filter by role
        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }
 
        // Filter by active status
        if ($request->has('is_active')) {
            $query->where('is_active', (bool) $request->query('is_active'));
        }
 
        $perPage = min((int) $request->query('per_page', 15), 100);
        $users   = $query->orderByDesc('created_at')->paginate($perPage);
 
        return response()->json($users);
    }
 
    /**
     * PATCH /admin/users/{id}/role
     * Change a user's role.
     *
     * Body: { "role": "website_worker" }
     */
    public function changeRole(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::in(['website_admin', 'website_worker', 'website_subscriber'])],
        ]);
 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
 
        $user = User::whereNull('deleted_at')->findOrFail($id);
 
        // Prevent an admin from demoting themselves
        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'You cannot change your own role.'], 403);
        }
 
        $user->update(['role' => $request->role]);
 
        // Revoke all existing tokens so the new role abilities take effect on next login
        $user->tokens()->delete();
 
        return response()->json([
            'message' => 'Role updated successfully.',
            'user'    => $this->formatUser($user),
        ]);
    }
 
    /**
     * PATCH /admin/users/{id}/toggle-active
     * Activate or deactivate a user account.
     */
    public function toggleActive(Request $request, int $id): JsonResponse
    {
        $user = User::whereNull('deleted_at')->findOrFail($id);
 
        // Prevent self-deactivation
        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'You cannot deactivate your own account.'], 403);
        }
 
        $user->update(['is_active' => !$user->is_active]);
 
        // If deactivating, revoke all their tokens immediately
        if (!$user->is_active) {
            $user->tokens()->delete();
        }
 
        return response()->json([
            'message'   => $user->is_active ? 'User activated.' : 'User deactivated and sessions revoked.',
            'is_active' => $user->is_active,
        ]);
    }
 
    /**
     * DELETE /admin/users/{id}
     * Soft-delete a user and revoke all their tokens.
     */
    public function deleteUser(Request $request, int $id): JsonResponse
    {
        $user = User::whereNull('deleted_at')->findOrFail($id);
 
        // Prevent self-deletion
        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'You cannot delete your own account.'], 403);
        }
 
        // Revoke tokens before deleting
        $user->tokens()->delete();
        $user->delete(); // triggers SoftDelete (sets deleted_at)
 
        return response()->json(['message' => 'User deleted successfully.']);
    }
 
    // ─── Private helpers ────────────────────────────────────────────────
 
    private function formatUser(User $user): array
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
