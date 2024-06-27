<?php

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for($i = 0; $i < 5; $i++)
        {
            $new_dish = new Dish();
            $new_dish->name = $faker->sentence(1,5);
            $new_dish->slug = Str::slug($new_dish->name);
            $new_dish->image ="https://picsum.photos/300/200?random=".rand(1,300);
            $new_dish->description = $faker->paragraph(3,15);
            $new_dish->ingredients = $faker->paragraph(2,10);
            $new_dish->price = $faker->randomFloat(2,1,200);
            $new_dish->visible = $faker->boolean();

            // dump($new_dish);
            $new_dish->save();
        }
    }
}
