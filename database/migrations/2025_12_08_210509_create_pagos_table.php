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
        Schema::create('pagos', function (Blueprint $table) {
            $table->string('rfc_cliente', 13);
            $table->date('fecha_pago');
            $table->string('tipo_contratacion', 10);
            
            $table->integer('total_pago');
            $table->enum('forma_pago', ['DEBITO', 'CRÉDITO', 'EFECTIVO', 'TRANSFERENCIA']);
            $table->boolean('reembolso')->default(false);

            $table->timestamps();

            $table->unique(['rfc_cliente', 'fecha_pago']);

            $table->foreign('rfc_cliente')
                  ->references('rfc')->on('alumnos')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('tipo_contratacion')
                  ->references('tipo_contratacion')->on('contratacion')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
