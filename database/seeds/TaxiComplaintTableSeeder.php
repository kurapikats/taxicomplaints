<?php

use Illuminate\Database\Seeder;

class TaxiComplaintTableSeeder extends Seeder
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
            DB::table('taxi_complaints')->insert([
                'taxi_id'           => $faker->numberBetween(1, 30),
                'incident_date'     => $faker->date,
                'incident_time'     => $faker->time,
                'incident_location' => $faker->city,
                'notes'             => $faker->paragraph(),
                'drivers_name'      => $faker->name,
                'created_by'        => $faker->numberBetween(1, 31),
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime
            ]);
        }
    }
}
