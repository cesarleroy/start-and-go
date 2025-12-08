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
        Schema::create('contratacion', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_contratacion', 15)->unique(); 

            $table->integer('precio');

            $table->string('desc_beneficios', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratacion');
    }
};
