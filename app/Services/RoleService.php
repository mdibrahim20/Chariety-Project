<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleService
{
    /**
     * Create a new role.
     */
    public function create(array $data): Role
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        
        return Role::create($data);
    }

    /**
     * Update a role.
     */
    public function update(Role $role, array $data): Role
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $role->update($data);
        
        return $role->fresh();
    }

    /**
     * Delete a role.
     */
    public function delete(Role $role): bool
    {
        // Prevent deletion of admin role
        if ($role->slug === 'admin') {
            throw new \Exception('Cannot delete admin role.');
        }

        return $role->delete();
    }

    /**
     * Sync permissions for a role.
     */
    public function syncPermissions(Role $role, array $permissionIds): void
    {
        $role->permissions()->sync($permissionIds);
    }

    /**
     * Get all roles with their permissions.
     */
    public function getAllWithPermissions()
    {
        return Role::with('permissions')->get();
    }

    /**
     * Find role by slug.
     */
    public function findBySlug(string $slug): ?Role
    {
        return Role::where('slug', $slug)->first();
    }
}
