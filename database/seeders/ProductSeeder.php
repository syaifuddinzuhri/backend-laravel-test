<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => $faker->words(4, true),
                'price' => $faker->randomFloat(2, 1, 1000),
                'product_category_id' => $faker->numberBetween(1, 10)
            ]);
        }
    }
}
