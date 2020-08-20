<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillables = ['Nombre','Descripcion','Condicion'];
    public $timestamps =false;

    //un rol puede tener varios usuarios
    public function users(){
        return $this->hasMany('App\User');
    }
}
