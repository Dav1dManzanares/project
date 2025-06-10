<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'fecha_inscripcion',
        'socio_id',
        'clase_id'
    ];

    protected $casts = [
        'fecha_inscripcion' => 'date'
    ];

    // Relaciones
    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}
