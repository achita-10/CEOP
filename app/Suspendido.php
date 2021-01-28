<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suspendido extends Model
{
    protected $fillable=[
        'Motivo',
        'FechaInactivo',
    ];
    public $timestamps = false;
}
