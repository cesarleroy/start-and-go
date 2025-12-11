<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contratacion extends Model
{
    protected $table = 'contratacion';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'tipo_contratacion',
        'precio',
        'desc_beneficios'
    ];

    // Relación con Pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'tipo_contratacion', 'tipo_contratacion');
    }
}