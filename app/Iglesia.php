<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    protected $fillable = [
        'ID_Miembro',
        'FechaConversion',
        'Bautizado',
        'FechaBautizo',
        'Iglesia',
        'FechaDeceso',
        'Deceso',
    ];    
    public $timestamps = false;
}
