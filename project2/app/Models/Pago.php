<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'monto',
        'fecha_pago',
        'membresia_id',
        'socio_id'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date'
    ];

    // Relaciones
    public function membresia()
    {
        return $this->belongsTo(Membresia::class);
    }

    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }
}
