<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categorias')->insert([
        	['categoria' => 'RELOJES'],
        	['categoria' => 'CELULARES'],
        	['categoria' => 'TV'],
        	['categoria' => 'COMPUTADORAS'],
        	['categoria' => 'TABLETS']
        ]);
    }
}
