<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'puntaje',
        'comentario',
        'socio_id',
        'clase_id'
    ];

    protected $casts = [
        'puntaje' => 'integer'
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
