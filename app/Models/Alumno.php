<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'rfc',
        'nombre',
        'apellido_p',
        'apellido_m',
        'fecha_nac',
        'calle',
        'numero',
        'colonia',
        'alcaldia',
        'permiso',
        'observaciones',
        'correo'
    ];

    protected $casts = [
        'fecha_nac' => 'date',
    ];

    // Relación con Pagos (usa RFC, no ID)
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'rfc_cliente', 'rfc');
    }
    
    // Relación con Agendas (usa RFC, no ID)
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'rfc_cliente', 'rfc');
    }
    
    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido_p} {$this->apellido_m}");
    }
}