<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = 'products'; // Nombre de la tabla en la base de datos
    protected $fillable = ['name', 'is_active']; // Campos que se pueden asignar masivamente

    // Puedes agregar relaciones, scopes, etc. aquí si es necesario
}
