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
            $table->string('RFC_EMP', 13);
            $table->date('FECHA');
            $table->time('HORA');
            
            // Resto de campos (con nombres exactos)
            $table->string('RFC_CLIENTE', 13);
            $table->date('FECHA_PAGO');
            $table->enum('ACTIVIDAD', ['EXAMEN', 'LECCIÓN'])->nullable();
            $table->integer('KM_RECORRIDOS')->nullable();
            $table->string('NOTAS', 50)->nullable();
            $table->integer('EXAM_TEO')->nullable();
            $table->integer('EXAM_PRAC')->nullable();
            $table->string('NOTAS_RESULTADO', 50)->nullable();
            
            // Claves primarias compuestas
            $table->primary(['FECHA', 'HORA', 'RFC_EMP']);
            
            // Índices para relaciones
            $table->foreign('rfc_emp')->references('rfc')->on('empleados');
            $table->foreign(['RFC_CLIENTE', 'FECHA_PAGO'])
                  ->references(['RFC_CLIENTE', 'FECHA_PAGO'])->on('pagos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agenda');
    }
};
