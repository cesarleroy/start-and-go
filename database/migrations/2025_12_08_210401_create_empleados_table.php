<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('rfc', 13)->unique();
            $table->string('nombre', 30);
            $table->string('apellido_p', 30);
            $table->string('apellido_m', 30);
            $table->string('puesto', 30);
            $table->enum('turno', ['Matutino', 'Vespertino']);
            $table->string('descansos', 30);
            $table->enum('sexo', ['Masculino', 'Femenino']);
            $table->date('fecha_nac');
            $table->bigInteger('tel_personal');
            $table->string('calle', 30);
            $table->integer('numero');
            $table->string('colonia', 30);
            $table->string('alcaldia', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
