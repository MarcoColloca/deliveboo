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
    public function run()
    {
        //leggi file json
        $json = File::get("database/json/dishes.json");
        $data = json_decode($json);

        foreach($data->dishes as $dish) {
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

            //inserisci dati nella taella ponte dish_order
            foreach($dish->order as $orderId) {
                DB::table('dish_order')->insert([
                    'dish_id' => $dishId,
                    'order_id' =>$orderId,
                ]);
            }
        }

    }
}
