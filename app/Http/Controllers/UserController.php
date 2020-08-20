<?php

namespace App\Http\Controllers;

use App\User;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $usuarios = User::join('usuarios','users.id','=','usuarios.id')
        ->join('roles','users.ID_Rol','=','roles.id')
        ->select('usuarios.*','users.*','roles.Nombre as Rol')
        ->where('users.Condicion','=','1')
        ->orderBy('usuarios.id','desc')->get();
        return[
            'usuarios'=>$usuarios
        ];
    } 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        //SE implementa un capturador de excepciones
        try {
            //Se utilizaran transacciones
            DB::beginTransaction();
            $usuario = new Usuario();
            $usuario->Nombre            =   $request->Nombre;
            $usuario->Apellido_P    =   $request->Apellido_P;
            $usuario->Apellido_M     =   $request->Apellido_M;
            $usuario->Genero         =   $request->Genero;
            $usuario->EstadoCivil          =   $request->EstadoCivil;
            $usuario->FechaNac             =   $request->FechaNac;
            $usuario->save();

            $user = new User();
            $user->id               =   $usuario->id;
            $user->usuario          =   $request->Usuario;
            $user->password         =   bcrypt($request->Contraseña);
            $user->Condicion        =   '1';
            $user->ID_Rol           =   $request->Rol;
            $user->save();
            DB::commit();
        } catch (Exception $th) {
            //throw $th;
            DB::rollBack();
        }
        
        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        //SE implementa un capturador de excepciones
        try {
            //Se utilizaran transacciones
            DB::beginTransaction();
            //Buscar primero el proveedor a modificar
            $user = User::findORFail($request->ID);
            //Buscar a ña persona que conincida con el id del proveedor
            $usuario = Usuario::findOrFail($user->id);
            $usuario->Nombre            =   $request->Nombre;
            $usuario->Apellido_P        =   $request->Apellido_P;
            $usuario->Apellido_M        =   $request->Apellido_M;
            $usuario->Genero            =   $request->Genero;
            $usuario->EstadoCivil       =   $request->EstadoCivil;
            $usuario->FechaNac          =   $request->FechaNac;
            $usuario->save();
            $user->usuario          =   $request->Usuario;
            $user->password         =   bcrypt($request->Contraseña);
            $user->Condicion        =   '1';
            $user->ID_Rol           =   $request->Rol;
            //El campo id ya no se modifica
            //$proveedor->id                  =   $usuario->id;
            $user->save();
            DB::commit();
        } catch (Exception $th) {
            //throw $th;
            DB::rollBack();
        }
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->ID);
        $user->Condicion   =   '0';
        $user->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->ID);
        $user->Condicion   =   '1';
        $user->save();
    }
}
