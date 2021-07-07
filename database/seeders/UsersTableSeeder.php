<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'root',
            'email' => 'admin@spreading.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Admin',
        ]);
    }
}
