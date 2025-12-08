<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

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
        'correo',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'rfc_cliente', 'rfc');
    }
}
