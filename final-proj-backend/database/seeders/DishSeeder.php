<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Dish;
use App\Models\Order;
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

        $company_ids = Company::all()->pluck('id')->all();
        $order_ids = Order::all()->pluck('id')->all();
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
            $new_dish->company_id = $faker->randomElement($company_ids);
            
            // dump($new_dish);
            $new_dish->save();

            $random_order_ids = $faker->randomElements($order_ids, rand(1, 3));

            $random_qty = [];

            foreach ($random_order_ids as $order_id) {
                $random_qty[$order_id] = ['qty' => rand(1, 5)];
            }

            $new_dish->orders()->attach($random_qty);

        }
    }
}
