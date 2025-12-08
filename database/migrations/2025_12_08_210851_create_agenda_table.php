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
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('rfc_emp', 13);
            $table->date('fecha');
            $table->time('hora');
            
            // Columnas para conectar con PAGOS
            $table->string('rfc_cliente', 13);
            $table->date('fecha_pago');

            // Detalles de la actividad
            $table->enum('actividad', ['EXAMEN', 'LECCIÓN']);
            $table->integer('km_recorridos')->nullable(); // En SQL no dice NOT NULL -> nullable
            $table->string('notas', 50)->nullable();
            
            $table->integer('exam_teo')->nullable();
            $table->integer('exam_prac')->nullable();
            $table->string('notas_resultado', 50)->nullable();

            $table->unique(['fecha', 'hora', 'rfc_emp']);

            $table->foreign('rfc_emp')
                  ->references('rfc')->on('empleados')
                  ->onUpdate('cascade');

            $table->foreign(['rfc_cliente', 'fecha_pago'])
                  ->references(['rfc_cliente', 'fecha_pago'])->on('pagos')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda');
    }
};
