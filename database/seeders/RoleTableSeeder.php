<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Roles')->insert([
           'name' => 'Admin',
           'slug' => 'admin',
        ]);
        DB::table('Roles')->insert([
            'name' => 'Author',
            'slug' => 'author',
        ]);
    }
}
