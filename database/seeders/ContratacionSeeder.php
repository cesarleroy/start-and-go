<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContratacionSeeder extends Seeder
{
    public function run(): void
    {
        // Insertamos los 3 tipos de contratación base
        $contrataciones = [
            [
                'tipo_contratacion' => 'BÁSICO',
                'precio' => 2000,
                'desc_beneficios' => '7 DÍAS, 3HRS X DÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_contratacion' => 'INTERMEDIO',
                'precio' => 3500,
                'desc_beneficios' => '12 DÍAS, 3.5HRS X DÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_contratacion' => 'PREMIUM',
                'precio' => 5000,
                'desc_beneficios' => '18 DÍAS, 4HRS X DÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('contratacion')->insertOrIgnore($contrataciones);
    }
}