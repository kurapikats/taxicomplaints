<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('users')->insert([
            'name'           => 'Jesus B. Nana',
            'email'          => 'kurapikats@yahoo.com',
            'password'       => bcrypt('secret'),
            'contact_number' => '09082150659',
            'address'        => 'Makati City',
            'role_id'        => 1,
            'photo'          => $faker->imageUrl(150, 150, 'cats')
        ]);

        foreach(range(1, 30) as $v)
        {
            DB::table('users')->insert([
                'name'           => $faker->name,
                'email'          => $faker->email,
                'password'       => bcrypt('secret'),
                'contact_number' => $faker->phoneNumber,
                'address'        => $faker->address,
                'role_id'        => $faker->numberBetween(1, 3),
                'photo'          => $faker->imageUrl(150, 150, 'cats'),
                'created_at'     => $faker->dateTime,
                'updated_at'     => $faker->dateTime
            ]);
        }
    }
}
