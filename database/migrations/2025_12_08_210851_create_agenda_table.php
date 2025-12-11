<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            // Clave primaria compuesta (igual que tu BD)
            $table->string('rfc_emp', 13);
            $table->date('fecha');
            $table->time('hora');
            
            // Resto de campos (con nombres exactos)
            $table->string('rfc_cliente', 13);
            $table->date('fecha_pago');
            $table->enum('actividad', ['examen', 'lección'])->nullable();
            $table->integer('km_recorridos')->nullable();
            $table->string('notas', 50)->nullable();
            $table->integer('exam_teo')->nullable();
            $table->integer('exam_prac')->nullable();
            $table->string('notas_resultado', 50)->nullable();

            $table->timestamps();
            
            // Claves primarias compuestas
            $table->primary(['fecha', 'hora', 'rfc_emp']);
            
            // Índices para relaciones
            $table->foreign('rfc_emp')->references('rfc')->on('empleados');
            $table->foreign(['rfc_cliente', 'fecha_pago'])
                  ->references(['rfc_cliente', 'fecha_pago'])->on('pagos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agenda');
    }
};
