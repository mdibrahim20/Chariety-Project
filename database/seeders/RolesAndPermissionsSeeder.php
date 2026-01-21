<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            ['name' => 'View Users', 'slug' => 'view-users', 'description' => 'Can view user list'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'description' => 'Can create new users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'description' => 'Can edit existing users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'description' => 'Can delete users'],
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'description' => 'Full user management access'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'description' => 'Can manage roles and permissions'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'description' => 'Can manage system settings'],
            ['name' => 'View Logs', 'slug' => 'view-logs', 'description' => 'Can view system logs'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        // Create Roles
        $adminRole = Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrator',
                'description' => 'Full system access',
            ]
        );

        $moderatorRole = Role::updateOrCreate(
            ['slug' => 'moderator'],
            [
                'name' => 'Moderator',
                'description' => 'Limited administrative access',
            ]
        );

        $userRole = Role::updateOrCreate(
            ['slug' => 'user'],
            [
                'name' => 'User',
                'description' => 'Standard user access',
            ]
        );

        // Assign all permissions to admin role
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Assign limited permissions to moderator role
        $moderatorPermissions = Permission::whereIn('slug', [
            'view-users',
            'edit-users',
            'view-logs',
        ])->get();
        $moderatorRole->permissions()->sync($moderatorPermissions->pluck('id'));

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
