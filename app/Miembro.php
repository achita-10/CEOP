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
        'FechaIngreso',
        'Grupo',
        'Ministerio',
        'Imagen',
        'Condicion'
    ];  
    public $timestamps = false;
    
    public function asistencia(){
        return $this->hasMany('App\Asistencia');
    }
}
