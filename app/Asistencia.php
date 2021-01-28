<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'ID_Miembro',
        'Condicion',
        'Fecha'
    ];    
    public $timestamps = false;

    
}
