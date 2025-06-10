<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Inscripcion;
use App\Models\Clase;
use App\Models\Evaluacion;  

class Socio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'direccion',
        'telefono',
        'email',
        'membresia_id'
    ];

    // Relaciones
    public function membresia()
    {
        return $this->belongsTo(Membresia::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'inscripciones');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}
