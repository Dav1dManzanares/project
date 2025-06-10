<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clase extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'horario',
        'capacidad',
        'entrenador_id'
    ];

    protected $casts = [
        'capacidad' => 'integer'
    ];

    // Relaciones
    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function socios()
    {
        return $this->belongsToMany(Socio::class, 'inscripciones');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    // Scope para clases con cupo disponible
    public function scopeConCupoDisponible($query)
    {
        return $query->whereRaw('capacidad > (SELECT COUNT(*) FROM inscripciones WHERE clase_id = clases.id)');
    }
}
