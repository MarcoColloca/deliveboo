<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Dish;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker)
    {
        //leggi file json
        $json = File::get("database/json/dishes.json");
        $data = json_decode($json);

        $order_ids = Order::all()->pluck('id')->all();


        foreach ($data->dishes as $dish) {
            //inserisci i dati nella tab dishes
            $dishId = DB::table('dishes')->insertGetId([
                'name' => $dish->name,
                'slug' => $dish->slug,
                'image' => $dish->image,
                'description' => $dish->description,
                'ingredients' => $dish->ingredients,
                'price' => $dish->price,
                'visible' => $dish->visible,
                'company_id' => $dish->company_id

            ]);

            $dish = Dish::find($dishId);


            $random_order_ids = $faker->randomElements($order_ids, rand(1, 3));
    
            $random_qty = [];
    
            foreach ($random_order_ids as $order_id) {
                $random_qty[$order_id] = ['qty' => rand(1, 5)];
            };
    
            $dish->orders()->attach($random_qty);

        };


    }
}
