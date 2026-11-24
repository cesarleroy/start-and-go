<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contratacion extends Model
{
    protected $table = 'contratacion';

    protected $fillable = [
        'tipo_contratacion',
        'precio',
        'horas_incluidas',
        'desc_beneficios',
    ];

    protected $casts = [
        'precio' => 'integer',
        'horas_incluidas' => 'integer',
    ];

    public function getHorasPorDiaAttribute(): int
    {
        return match (mb_strtoupper(trim($this->tipo_contratacion))) {
            'BÁSICO', 'BASICO' => 2,
            'INTERMEDIO' => 3,
            'INTENSIVO' => 4,
            'PREMIUM' => 5,
            default => 2,
        };
    }

    public function getDiasIncluidosAttribute(): int
    {
        return (int) ceil($this->horas_incluidas / max(1, $this->horas_por_dia));
    }

    public function getListaBeneficiosAttribute(): array
    {
        $resumenTiempo = "{$this->dias_incluidos} días de clase ({$this->horas_por_dia} hrs/día · {$this->horas_incluidas} hrs totales)";

        return match (mb_strtoupper(trim($this->tipo_contratacion))) {
            'BÁSICO', 'BASICO' => [
                $resumenTiempo,
                'Instrucción práctica desde cero en vehículo de doble control',
                'Manual digital del Reglamento de Tránsito CDMX',
                'Instructor certificado asignado',
                'Evaluación diagnóstica de manejo',
            ],
            'INTERMEDIO' => [
                $resumenTiempo,
                'Práctica en tránsito urbano, glorietas y avenidas principales',
                'Guía teórica + simulador de examen escrito',
                'Vehículo escuela con seguro de cobertura amplia',
                'Aplicación de examen teórico y práctico final',
            ],
            'INTENSIVO' => [
                $resumenTiempo,
                'Capacitación acelerada en estacionamiento y vía rápida',
                'Asesoría teórica personalizada y material de estudio',
                'Examen teórico y práctico final incluido',
                'Flexibilidad para reagendar con 24 hrs de anticipación',
            ],
            'PREMIUM' => [
                $resumenTiempo,
                'Dominio integral: ciudad, carretera y conducción defensiva',
                'Prioridad de horarios matutinos y vespertinos',
                'Examen final con derecho a 1 reposición sin costo',
                'Constancia oficial de acreditación Start & Go',
            ],
            default => [
                $resumenTiempo,
                'Vehículo escuela equipado con doble control',
                'Seguimiento en portal LUGIA',
            ],
        };
    }
}