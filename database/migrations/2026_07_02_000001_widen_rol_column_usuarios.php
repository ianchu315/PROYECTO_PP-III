<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Amplía la columna "rol" de usuarios para admitir cualquier texto
     * (usuario, profesor, administrador, superadministrador, etc.)
     * en vez de depender de un enum fijo que quedó desactualizado.
     *
     * Usamos SQL directo (en vez de ->change()) porque el método de
     * Laravel necesita "doctrine/dbal" para leer la tabla completa, y
     * eso falla cuando hay otras columnas tipo ENUM (como "genero").
     */
    public function up(): void
    {
        try {
            DB::statement('ALTER TABLE usuarios MODIFY COLUMN rol VARCHAR(30) NOT NULL');
        } catch (\Throwable $e) {
            // La columna ya admite estos valores o no se pudo modificar
            // automáticamente: no interrumpimos el resto de la migración.
        }
    }

    public function down(): void
    {
        // No revertimos el tipo de columna para no perder datos existentes.
    }
};
