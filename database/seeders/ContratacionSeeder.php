<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContratacionSeeder extends Seeder
{
    public function run(): void
    {
        $contrataciones = [
            [
                'tipo_contratacion' => 'BÁSICO',
                'precio' => 2000,
                'horas_incluidas' => 14, // 7 días * 2 hrs
                'desc_beneficios' => '7 DÍAS, 2HRS X DÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_contratacion' => 'INTERMEDIO',
                'precio' => 3500,
                'horas_incluidas' => 30, // 10 días * 3 hrs
                'desc_beneficios' => '10 DÍAS, 3HRS X DÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_contratacion' => 'INTENSIVO',
                'precio' => 4000,
                'horas_incluidas' => 60, // 15 días * 4 hrs
                'desc_beneficios' => '15 DÍAS, 4HRS X DÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_contratacion' => 'PREMIUM',
                'precio' => 5000,
                'horas_incluidas' => 100, // 20 días * 5 hrs
                'desc_beneficios' => '20 DÍAS, 5HRS X DÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Inserta si no existen o actualiza precio, horas_incluidas y beneficios sin romper FKs en pagos
        DB::table('contratacion')->upsert(
            $contrataciones,
            ['tipo_contratacion'],
            ['precio', 'horas_incluidas', 'desc_beneficios', 'updated_at']
        );
    }
}