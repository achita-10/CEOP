<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $fillable = [
        'Nombre',
        'Apellido_P',
        'Apellido_M',
        'Correo',
        'Telefono',
        'Congregacion',
        'RedSocial',
        'Imagen'
    ];  
}
