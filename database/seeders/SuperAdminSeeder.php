<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Crea (o actualiza si ya existe) el usuario superadministrador
     * que puede aprobar/rechazar el registro de los demás usuarios.
     *
     * Cambiá el email y la contraseña por los que quieras usar.
     */
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['email' => 'superadmin@campus.com'],
            [
                'nombre'   => 'Super',
                'apellido' => 'Administrador',
                'password' => Hash::make('CambiarEsta123'),
                'rol'      => 'superadministrador',
                'estado'   => 'aprobado',
                'aprobado' => true,
                'perfil_completado' => true,
            ]
        );
    }
}
