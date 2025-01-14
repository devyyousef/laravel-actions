<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Users\Enums\RolesEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-role',
            'read-roles',
            'update-role',
            'delete-role',
            'create-permission',
            'read-permissions',
            'update-permission',
            'delete-permission',
            'assign-role',
            'sync-roles',
            'assign-permission',
            'sync-permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }
        $role = Role::findOrCreate(RolesEnum::SUPER_ADMIN->value);
        $role->givePermissionTo($permissions);
    }
}
