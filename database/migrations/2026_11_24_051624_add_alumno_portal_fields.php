<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contratacion', function (Blueprint $table) {
            $table->integer('horas_incluidas')->default(5)->after('precio');
            $table->text('desc_beneficios')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('rfc_alumno', 13)->nullable()->after('role');
            $table->foreign('rfc_alumno')
                  ->references('rfc')
                  ->on('alumnos')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['rfc_alumno']);
            $table->dropColumn('rfc_alumno');
        });

        Schema::table('contratacion', function (Blueprint $table) {
            $table->dropColumn('horas_incluidas');
        });
    }
};
