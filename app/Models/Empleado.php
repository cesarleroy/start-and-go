<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

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
        'alcaldia',
    ];

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'rfc_emp', 'rfc');
    }
}
