<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    // Nombre de la tabla
    protected $table = 'alumnos';


    protected $primaryKey = 'rfc';
    public $incrementing = false;
    protected $keyType = 'string';

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

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'rfc_cliente', 'rfc');
    }


    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'rfc_cliente', 'rfc');
    }

    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido_p} {$this->apellido_m}");
    }
}
