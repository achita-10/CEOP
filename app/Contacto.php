<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $fillable = [
        'ID_Miembro',
        'Correo',
        'Telefono',
        'Direccion',
        'Ocupacion',
        'Padre',
        'Madre',
    ];    
    public $timestamps = false;
}
