<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 5; $i++) {
            $new_order = new Order();
            $new_order->customer_name = $faker->name();
            $new_order->customer_address = $faker->streetAddress();
            $new_order->customer_phone = $faker->phoneNumber();
            $new_order->customer_email = $faker->email();
            $new_order->details = $faker->paragraph(3,10);
            $new_order->total = $faker->randomFloat(2,20,300);

            // dump($new_dish);
            $new_order->save();
        }
    }

}
