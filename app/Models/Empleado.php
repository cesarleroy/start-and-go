<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true; // Tiene created_at y updated_at

    protected $fillable = [
        'rfc',
        'nombre',
        'apellido_p',
        'apellido_m',
        'puesto',
        'turno',
        'descansos',
        'sexo',
        'fecha_nac',
        'tel_personal',
        'calle',
        'numero',
        'colonia',
        'alcaldia'
    ];

    protected $casts = [
        'fecha_nac' => 'date',
    ];

    // Relación con Agenda (usa RFC, no ID)
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'rfc_emp', 'rfc');
    }
    
    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido_p} {$this->apellido_m}");
    }
}