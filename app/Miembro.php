<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    protected $fillable = [
        'Nombre',
        'Apellido_P',
        'Apellido_M',
        'Genero',
        'EstadoCivil',
        'FechaNac',
        'Imagen'
    ];  
}
