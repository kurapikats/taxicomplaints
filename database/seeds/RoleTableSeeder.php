<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'          => 'Admin',
            'description'   => 'Administrator\'s Account'
        ]);

        DB::table('roles')->insert([
            'name'          => 'Moderator',
            'description'   => 'Moderator\'s  Account'
        ]);

        DB::table('roles')->insert([
            'name'          => 'Regular',
            'description'   => 'Regular User\'s Account'
        ]);
    }
}
