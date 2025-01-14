<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Users\Enums\RolesEnum;
use Modules\Users\Models\User;
use Spatie\Permission\Models\Role;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => 'password',
            ]
        );
        $role = Role::findOrCreate(RolesEnum::SUPER_ADMIN->value);
        $admin->assignRole($role);
    }
}
