<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(AgenciasTableSeeder::class);
        $this->call(DeliverysTableSeeder::class);
        $this->call(PartidosZonasTablesSeeder::class);
        $this->call(TarifasTableSeeder::class);
        $this->call(CategoriasTableSeeder::class);
        $this->call(ProductosTableSeeder::class);
        $this->call(ClientesTableSeeder::class);
        $this->call(FuentesTableSeeder::class);
        $this->call(MercadoPagoTablesSeeder::class);
    }
}
