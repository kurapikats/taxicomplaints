<?php

use Illuminate\Database\Seeder;

class ViolationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('violations')->insert([
            ['name' => 'Choosing passengers'],
            ['name' => 'Dilapidated unit'],
            ['name' => 'No meter'],
            ['name' => 'No taxi details inside'],
            ['name' => 'Out of line operation'],
            ['name' => 'Reckless driving'],
            ['name' => 'Rude behaviour'],
            ['name' => 'Smoking while driving'],
            ['name' => 'Cutting trip'],
            ['name' => 'Dirty seats and interiors'],
            ['name' => 'No receipt'],
            ['name' => 'Non-compliance with traffic regulations'],
            ['name' => 'Overcharging / undercharging'],
            ['name' => 'Refusal to grant discount'],
            ['name' => 'Sexual assault / Verbal harassment'],
            ['name' => 'Tampered or broken meter'],
            ['name' => 'Discriminating against Persons with Disabilities (PWDs)'],
            ['name' => 'No flag down of meter'],
            ['name' => 'No seatbelts'],
            ['name' => 'Not giving exact change'],
            ['name' => 'Physical assault'],
            ['name' => 'Refusal to board or convey'],
            ['name' => 'Smelly interiors'],
            ['name' => 'Texting while driving']
        ]);
    }
}
