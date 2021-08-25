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
            'name' => 'Marisol',
            'email' => 'marisol@spreading.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Recepcionista',
        ]);
        \DB::table('users')->insert([
            'name' => 'Genesis',
            'email' => 'genesis@spreading.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Coordinador(a)',
        ]);

        \DB::table('recepcionistas')->insert([
            'nombres' => 'Marisol',
            'apellidos' => 'Medina',
            'id_user' => 2,
        ]);
    }
}
