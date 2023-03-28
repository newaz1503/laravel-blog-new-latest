<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Newaz Sharif',
            'username' => 'Newaz',
            'email' => 'newazcse@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Raju Ahmed',
            'username' => 'Raju',
            'email' => 'raju@gmail.com',
            'password' => bcrypt('1234567'),
        ]);
    }
}
