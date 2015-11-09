<?php

use Illuminate\Database\Seeder;

class TaxiViolationTableSeeder extends Seeder
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
            DB::table('taxi_violations')->insert([
                'taxi_complaint_id' => $faker->numberBetween(1, 60),
                'violation_id'      => $faker->numberBetween(1, 24),
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime
            ]);
        }
    }
}
