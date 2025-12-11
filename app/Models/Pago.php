<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    
    // Llave primaria compuesta
    protected $primaryKey = ['rfc_cliente', 'fecha_pago'];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'rfc_cliente',
        'fecha_pago',
        'tipo_contratacion',
        'total_pago',
        'forma_pago',
        'reembolso'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'reembolso' => 'boolean',
    ];

    // Relación con Alumno (usa RFC)
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'rfc_cliente', 'rfc');
    }
    
    // Relación con Contratación
    public function contratacion()
    {
        return $this->belongsTo(Contratacion::class, 'tipo_contratacion', 'tipo_contratacion');
    }
    
    // Relación con Agendas
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'rfc_cliente', 'rfc_cliente')
                    ->where('fecha_pago', $this->fecha_pago);
    }
    
    // Override para manejar llave primaria compuesta en consultas
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
    
    // Método helper para obtener la ruta de la clave
    public function getRouteKey()
    {
        return implode('-', [
            $this->getAttribute('rfc_cliente'),
            $this->getAttribute('fecha_pago')
        ]);
    }
}