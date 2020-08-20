<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
class Rolcontroller extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $roles = Rol::orderBy('id','desc')->get();   
        return[
            'roles'=>$roles
        ];
        
        //return $categorias;
    } 
    /*Funcion utilizada por UserController */
    public function seleccionarRol(){
        $roles = Rol::where('Condicion','=','1')
        ->select('id','Nombre')
        ->orderBy('Nombre','asc')->get();
        return ['roles'=>$roles];
    }
}
