<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Asistencia con jerarquía numérica: ausente = 0, tardanza = 1, presente = 2.
 * Lo que vale es siempre el ÚLTIMO dato cargado (planilla del profesor o QR),
 * no el "más alto".
 *
 *  - asistencias.estado pasa de texto a TINYINT (0/1/2). Se convierten los
 *    datos existentes: presente→2, tarde→1, ausente→0 y justificado→0 (la
 *    justificación queda en motivo_justificacion, que ahora significa
 *    "ausencia justificada").
 *  - asistencias.codigo_qr_id: de qué QR salió el registro actual (null si
 *    lo cargó el profesor a mano). Si el profesor lo corrige después, vuelve
 *    a null: así "quién se marcó con el QR" siempre refleja el dato vigente.
 *  - codigos_qr_asistencia.tipo: qué valor graba el QR (2 = presente,
 *    1 = tardanza).
 */
return new class extends Migration
{
    public function up(): void
    {
        $tipoActual = DB::selectOne(
            "SELECT DATA_TYPE AS t FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'asistencias' AND COLUMN_NAME = 'estado'"
        )->t ?? null;

        if ($tipoActual !== null && $tipoActual !== 'tinyint') {
            DB::table('asistencias')->where('estado', 'justificado')
                ->whereNull('motivo_justificacion')->update(['motivo_justificacion' => 'Justificada']);

            DB::table('asistencias')->where('estado', 'presente')->update(['estado' => '2']);
            DB::table('asistencias')->where('estado', 'tarde')->update(['estado' => '1']);
            DB::table('asistencias')->whereIn('estado', ['ausente', 'justificado'])->update(['estado' => '0']);

            DB::statement('ALTER TABLE asistencias MODIFY estado TINYINT UNSIGNED NOT NULL DEFAULT 2');
        }

        if (!Schema::hasColumn('asistencias', 'codigo_qr_id')) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->unsignedBigInteger('codigo_qr_id')->nullable()->after('registrado_por');
                $table->foreign('codigo_qr_id')->references('id')->on('codigos_qr_asistencia')
                    ->onDelete('set null')->onUpdate('cascade');
            });
        }

        if (!Schema::hasColumn('codigos_qr_asistencia', 'tipo')) {
            Schema::table('codigos_qr_asistencia', function (Blueprint $table) {
                $table->unsignedTinyInteger('tipo')->default(2)->after('token');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('codigos_qr_asistencia', 'tipo')) {
            Schema::table('codigos_qr_asistencia', function (Blueprint $table) {
                $table->dropColumn('tipo');
            });
        }

        if (Schema::hasColumn('asistencias', 'codigo_qr_id')) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->dropForeign(['codigo_qr_id']);
                $table->dropColumn('codigo_qr_id');
            });
        }

        DB::statement("ALTER TABLE asistencias MODIFY estado VARCHAR(20) NOT NULL DEFAULT 'presente'");
        DB::table('asistencias')->where('estado', '2')->update(['estado' => 'presente']);
        DB::table('asistencias')->where('estado', '1')->update(['estado' => 'tarde']);
        DB::table('asistencias')->where('estado', '0')->update(['estado' => 'ausente']);
    }
};
