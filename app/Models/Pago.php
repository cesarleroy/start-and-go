<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'rfc_cliente',
        'fecha_pago',
        'tipo_contratacion',
        'total_pago',
        'forma_pago',
        'reembolso',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'rfc_cliente', 'rfc');
    }

    public function contratacion()
    {
        return $this->belongsTo(Contratacion::class, 'tipo_contratacion', 'tipo_contratacion');
    }
}
