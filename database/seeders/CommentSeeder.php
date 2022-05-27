<?php

namespace Database\Seeders;

use App\Models\CommentModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class CommentSeeder extends Seeder
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
            CommentModel::create([
                'customer_id' => random_int(1, 4),
                'product_id' => random_int(1, 19),
                'rating' => random_int(1, 5),
                'comment' => $faker->text,
                'commented_date' => $faker->date($format = "Y-m-d", $max = 'now'),
            ]);
        }
    }
}
