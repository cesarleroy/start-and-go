<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumno extends Model
{
    protected $table = 'alumnos';
    use HasFactory;

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

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'rfc_cliente', 'rfc');
    }
}
