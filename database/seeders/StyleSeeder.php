<?php

namespace Database\Seeders;

use App\Models\StyleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class StyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i < 4; $i++) {
            StyleModel::create([
                'name' => $faker->name,
                'description' => $faker->text
            ]);
        }
    }
}
