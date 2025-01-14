<?php

namespace Database\Seeders;

use App\Models\Post;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Modules\Users\Database\Seeders\RolePermissionSeeder;
use Modules\Users\Database\Seeders\UsersDatabaseSeeder;
use Modules\Users\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UsersDatabaseSeeder::class,
        ]);
    }
}
