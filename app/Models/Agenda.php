<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';

    protected $fillable = [
        'rfc_emp',
        'fecha',
        'hora',
        'rfc_cliente',
        'fecha_pago',
        'actividad',
        'km_recorridos',
        'notas',
        'exam_teo',
        'exam_prac',
        'notas_resultado',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'rfc_emp', 'rfc');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'rfc_cliente', 'rfc');
    }
}
