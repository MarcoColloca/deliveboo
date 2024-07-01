<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $user_ids = User::all()->pluck('id')->all();

        $type_ids = Type::all()->pluck('id')->all();


        for($i = 0; $i < 10; $i++)
        {
            $new_company = new Company();

            $new_company->name = $faker->sentence(2, 4);
            $new_company->slug = Str::slug($new_company->name);
            $new_company->image = "https://picsum.photos/400/300?random=".rand(1,300);
            $new_company->city = $faker->city();
            $new_company->address = $faker->streetAddress();
            $new_company->vat_number = $faker->numerify('###########');
            $new_company->description = $faker->paragraph(3, 10);
            $new_company->phone_number = $faker->phoneNumber();
            $new_company->email = $faker->companyEmail();
            $new_company->user_id = $faker->randomElement($user_ids);

            $new_company->save();

            $random_type_ids = $faker->randomElements($type_ids, rand(1, 3));
            $new_company->types()->attach($random_type_ids);


        }
    }
}
