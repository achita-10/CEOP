<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    protected $fillable = [
        'ID_Miembro',
        'FechaIngreso',
        'FechaConversion',
        'Bautizado',
        'FechaBautizo',
        'Iglesia',
        'Grupo',
        'Ministerio',
        'FechaDeceso',
    ];    
    public $timestamps = false;
}
