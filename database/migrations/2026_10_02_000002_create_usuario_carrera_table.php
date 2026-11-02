<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_carrera', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('carrera_id');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('cascade');
            $table->unique(['usuario_id', 'carrera_id']);
        });

        DB::table('usuarios')
            ->whereIn('rol', ['profesor', 'usuario'])
            ->whereNotNull('carrera_id')
            ->get(['id', 'carrera_id'])
            ->each(function ($usuario) {
                DB::table('usuario_carrera')->insertOrIgnore([
                    'usuario_id' => $usuario->id,
                    'carrera_id' => $usuario->carrera_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_carrera');
    }
};