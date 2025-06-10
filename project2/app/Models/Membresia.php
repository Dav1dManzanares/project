<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membresia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'duracion',
        'monto'
    ];

    protected $casts = [
        'monto' => 'decimal:2'
    ];

    // Relaciones
    public function socios()
    {
        return $this->hasMany(Socio::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
