<?php

namespace Modules\Management\UserManagement\Role\Database\Seeders;

use Modules\Management\UserManagement\Role\Database\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Define all module routes and their permissions
        $permissions = [
               // Settings
            'Settings' => [
                ['name' => 'View Settings', 'slug' => 'settings-view', 'route' => '/admin#/settings'],
                ['name' => 'Edit Settings', 'slug' => 'settings-edit', 'route' => '/api/v1/settings/update'],
            ],
            // Dashboard
            'Dashboard' => [
                ['name' => 'View Dashboard', 'slug' => 'dashboard-view', 'route' => '/admin#/dashboard'],
            ],

            // User Management
            'User Management' => [
                ['name' => 'View Users', 'slug' => 'user-view', 'route' => '/admin#/user/all'],
                ['name' => 'Create User', 'slug' => 'user-create', 'route' => '/admin#/user/create'],
                ['name' => 'Edit User', 'slug' => 'user-edit', 'route' => '/admin#/user/edit'],
                ['name' => 'Delete User', 'slug' => 'user-delete', 'route' => '/api/v1/users/destroy'],
                ['name' => 'View User Details', 'slug' => 'user-details', 'route' => '/admin#/user/details'],
                ['name' => 'Import Users', 'slug' => 'user-import', 'route' => '/api/v1/users/import'],
            ],
            // Role Management
            'Role Management' => [
                ['name' => 'View Roles', 'slug' => 'role-view', 'route' => '/admin#/role/all'],
                ['name' => 'Create Role', 'slug' => 'role-create', 'route' => '/admin#/role/create'],
                ['name' => 'Edit Role', 'slug' => 'role-edit', 'route' => '/admin#/role/edit'],
                ['name' => 'Delete Role', 'slug' => 'role-delete', 'route' => '/api/v1/roles/destroy'],
                ['name' => 'View Role Details', 'slug' => 'role-details', 'route' => '/admin#/role/details'],
                ['name' => 'Manage Permissions', 'slug' => 'role-permission-manage', 'route' => '/api/v1/permissions'],
                ['name' => 'Import Roles', 'slug' => 'role-import', 'route' => '/api/v1/roles/import'],
            ],
         






            // [MODULE:Website Management:START]
            // Website Management
            'Website Management' => [
                ['name' => 'View Who We Are', 'slug' => 'who-we-are-view', 'route' => '/admin#/who-we-are/all'],
                ['name' => 'View Who We Are Details', 'slug' => 'who-we-are-details', 'route' => '/admin#/who-we-are/details'],
                ['name' => 'Create Who We Are', 'slug' => 'who-we-are-create', 'route' => '/admin#/who-we-are/create'],
                ['name' => 'Edit Who We Are', 'slug' => 'who-we-are-edit', 'route' => '/admin#/who-we-are/edit'],
                ['name' => 'Delete Who We Are', 'slug' => 'who-we-are-delete', 'route' => '/api/v1/who-we-ares/destroy'],
                ['name' => 'Import Who We Are', 'slug' => 'who-we-are-import', 'route' => '/api/v1/who-we-ares/import'],
            ],
            // [MODULE:Website Management:END]
        ];

        // Insert permissions
        foreach ($permissions as $category => $items) {
            foreach ($items as $permission) {
                Permission::firstOrCreate(
                    ['slug' => $permission['slug']],
                    [
                        'name' => $permission['name'],
                        'route' => $permission['route'],
                        'category' => $category,
                        'status' => 'active'
                    ]
                );
            }
        }
    }
}