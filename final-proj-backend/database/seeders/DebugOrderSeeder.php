<?php

namespace Database\Seeders;
use App\Models\Company;
use App\Models\Dish;
use App\Models\Order;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DebugOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        //leggi file json
        $json = File::get("database/json/dishes.json");
        $data = json_decode($json);

        //prendo l'id dei piatti della compagnia scelata e li metto in un array
        $dishes = Dish::where('company_id', 4)->pluck('id');
        // dump($dishes);

        $name_customers = ['Paolo', 'Marco', 'Francesca', 'Moustafa' ,'Gianni', 'Samuel', 'Donato', 'Gianluca', 'Massimo', 'Diego'];
        $surname_customers = ['Calcagni', 'Colloca', 'Ibrahim' , 'Barletta', 'Saladino', 'Riccio', 'Panicucci', 'Piazza', 'Giraudo', 'Lomarco'];
        // Creo un array per tenere traccia della compagnia associata a ciascun ordine
        $debug_order_company_map = [];

        for ($i = 0; $i < 50; $i++) {
            $test_order = new Order();
            $test_order->customer_name = $faker->randomElement($name_customers).' '.$faker->randomElement($surname_customers);
            $test_order->customer_address = $faker->streetAddress();
            $test_order->customer_phone = $faker->phoneNumber();
            $test_order->customer_email = $faker->email();
            $test_order->details = $faker->sentences(2, 10);
            $test_order->total = $faker->numberBetween(40, 210);


            $test_order->save();

            $random_dish = $faker->randomElement($dishes);

            $test_order->dishes()->attach($random_dish);

            // dump($test_order);
        }
    }
}
