<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model
{
    protected $fillable = [
        'Nombre',
        'Encargado',
    ];    
    public $timestamps = false;
}
