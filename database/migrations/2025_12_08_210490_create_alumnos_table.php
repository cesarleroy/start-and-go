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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('rfc');
            $table->string('nombre');
            $table->string('apellido_p');
            $table->string('apellido_m')->nullable();
            $table->date('fecha_nac');
            $table->string('calle');
            $table->string('numero');
            $table->string('colonia');
            $table->string('alcaldia');
            $table->string('permiso');
            $table->text('observaciones')->nullable();
            $table->string('correo')->nullable();
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
