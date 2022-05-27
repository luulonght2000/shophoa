<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            \Database\Seeders\UserSeeder::class,
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\CommentSeeder::class,
            \Database\Seeders\CustomerSeeder::class,
            \Database\Seeders\ProductSeeder::class,
            \Database\Seeders\StyleSeeder::class,
            \Database\Seeders\RoleSeeder::class,
        ]);
    }
}
