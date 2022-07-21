<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i < 10; $i++) {
            User::create([
                'name' => "User0$i",
                'email' => "User0$i@gmail.com",
                'password' => md5("Password$i"),
                'DOB' => $faker->date($format = "Y-m-d", $max = 'now'),
                'sex' => $faker->boolean,
                'address' => $faker->address,
            ]);
        }
    }
}
