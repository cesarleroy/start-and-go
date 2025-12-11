<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

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
        'notas_resultado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_pago' => 'date',
    ];

    // Relación con Empleado (usa RFC del empleado)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'rfc_emp', 'rfc');
    }

    // Relación con Alumno (usa RFC del cliente)
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'rfc_cliente', 'rfc');
    }
    
    // Relación con Pago (más compleja por llave compuesta)
     public function pago()
    {
        return $this->hasOne(Pago::class, 'rfc_cliente', 'rfc_cliente')
            ->whereColumn('pagos.fecha_pago', 'agenda.fecha_pago');
    }
}