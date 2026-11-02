<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('profesors', 'usuario_id')) {
            return;
        }

        Schema::table('profesors', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->nullable()->after('nombre');
            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::table('profesors', function (Blueprint $table) {
            $table->dropIndex(['usuario_id']);
            $table->dropColumn('usuario_id');
        });
    }
};
