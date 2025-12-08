<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contratacion extends Model
{
    protected $table = 'contratacion';

    protected $fillable = [
        'tipo_contratacion',
        'precio',
        'desc_beneficios',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'tipo_contratacion', 'tipo_contratacion');
    }
}
