<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new user.
     */
    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    /**
     * Update a user.
     */
    public function update(User $user, array $data): User
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        
        return $user->fresh();
    }

    /**
     * Delete a user.
     */
    public function delete(User $user): bool
    {
        // Prevent deletion of the last admin
        if ($user->isAdmin()) {
            $adminCount = User::where('is_admin', true)->count();
            if ($adminCount <= 1) {
                throw new \Exception('Cannot delete the last admin user.');
            }
        }

        return $user->delete();
    }

    /**
     * Assign roles to a user.
     */
    public function assignRoles(User $user, array $roleIds): void
    {
        $user->roles()->sync($roleIds);
    }

    /**
     * Toggle admin status.
     */
    public function toggleAdmin(User $user): User
    {
        $user->update(['is_admin' => !$user->is_admin]);
        
        return $user->fresh();
    }

    /**
     * Toggle 2FA requirement.
     */
    public function toggleTwoFactorRequired(User $user): User
    {
        $user->update(['two_factor_required' => !$user->two_factor_required]);
        
        return $user->fresh();
    }

    /**
     * Get users with specific role.
     */
    public function getUsersByRole(string $roleSlug)
    {
        return User::whereHas('roles', function ($query) use ($roleSlug) {
            $query->where('slug', $roleSlug);
        })->get();
    }

    /**
     * Search users.
     */
    public function search(string $query)
    {
        return User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();
    }
}
