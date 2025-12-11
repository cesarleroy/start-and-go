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

    // Relaciones (se mantienen igual)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'rfc_emp', 'rfc');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'rfc_cliente', 'rfc');
    }
    
    public function pago()
    {
        // Relación ajustada para buscar por cliente y fecha de pago
        return $this->belongsTo(Pago::class, 'rfc_cliente', 'rfc_cliente')
                    ->where('fecha_pago', $this->fecha_pago);
    }
}