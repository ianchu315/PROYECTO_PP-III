<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Índices pensados para cuando la base tenga varios cientos de usuarios y
// se busque/filtre seguido por nombre, apellido, carrera o materia
// asignada: sin índice, cada búsqueda hace un recorrido completo de la
// tabla (más lento cuanto más crece la tabla).
//
// Usamos SQL directo con try/catch (mismo criterio que la migración que
// amplía la columna "rol") para que, si algún índice ya existe o el motor
// de alguna instalación puntual no lo permite, no se corte toda la
// migración para el resto del equipo.
return new class extends Migration
{
    private array $indices = [
        'usuarios' => [
            'usuarios_rol_estado_index' => '(rol, estado)',
            'usuarios_apellido_index' => '(apellido)',
            'usuarios_nombre_index' => '(nombre)',
        ],
        'materias' => [
            'materias_carrera_id_index' => '(carrera_id)',
            'materias_profesor_usuario_id_index' => '(profesor_usuario_id)',
        ],
    ];

    public function up(): void
    {
        foreach ($this->indices as $tabla => $lista) {
            foreach ($lista as $nombre => $columnas) {
                try {
                    DB::statement("CREATE INDEX {$nombre} ON {$tabla} {$columnas}");
                } catch (\Throwable $e) {
                    // Ya existe o no se pudo crear: seguimos con el resto.
                }
            }
        }
    }

    public function down(): void
    {
        foreach ($this->indices as $tabla => $lista) {
            foreach (array_keys($lista) as $nombre) {
                try {
                    DB::statement("DROP INDEX {$nombre} ON {$tabla}");
                } catch (\Throwable $e) {
                    //
                }
            }
        }
    }
};
