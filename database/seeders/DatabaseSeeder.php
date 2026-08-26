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
        $this->call([
            UsersTableSeeder::class,     // admins base (tabla users)
            CarreraSeeder::class,        // carreras (necesarias para el registro de alumnos)
            NoticiasTableSeeder::class,
            EtiquetaSeeder::class,
            SuperAdminSeeder::class,     // <-- AGREGADO: crea el superadmin que aprueba/rechaza alumnos
        ]);
    }
}
