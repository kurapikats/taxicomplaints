<?php

use Illuminate\Database\Seeder;

class TaxiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 30) as $v)
        {
            DB::table('taxis')->insert([
                'plate_number'  => strtoupper(str_random(3)) . $faker->randomNumber(3),
                'name'          => $faker->name,
                'description'   => $faker->paragraph(),
                'created_at'    => $faker->dateTime,
                'updated_at'    => $faker->dateTime
            ]);
        }
    }
}
