<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i < 20; $i++) {
            ProductModel::create([
                'name' => $faker->name,
                'category_id' => random_int(1, 8),
                'description' => $faker->text,
                'style_id' => random_int(1, 3),
            ]);
        }
    }
}
