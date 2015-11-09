<?php

use Illuminate\Database\Seeder;

class TaxiPictureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 60) as $v)
        {
            DB::table('taxi_pictures')->insert([
                'taxi_id'           => $faker->numberBetween(1, 30),
                'taxi_complaint_id' => $faker->numberBetween(1, 60),
                'path'              => $faker->imageUrl(640, 480, 'cats'),
                'description'       => $faker->paragraph(),
                'created_by'        => $faker->numberBetween(1, 31),
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime
            ]);
        }
    }
}
