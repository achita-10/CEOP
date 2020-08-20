<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }
    //verificar las credenciales del uso del sistema

    public function login(Request $request){
        //validar el inicio de sesion del usuario
        // $this->validate($request,[
        //     'usuario'   =>  'required|string',
        //     'password'  =>  'required|string',
        // ]);
        $this->validateLogin($request);

        //Verificar si el usuario y la contraseña son correctas.
        //ademas verificar que el campo Condicion del usuario es 1. es decir que esta activo
        if(Auth::attempt(['usuario'=>$request->usuario,'password'=>$request->password,'Condicion'=>1])){
            //Si los datos de sesion son correctos redireccionar al inicio del sistema
            return redirect()->route('inicio');

        }
        //Esta instruccion devuelve los errores de validacion cuando un usuario ingresa datos erroneos
        return back()
        ->withErrors(['usuario'=>trans('auth.failed')])
        //Devuelve el usuario cuando se ingresa una contraseña incorrecta
        ->withInput(request(['usuario']));
    }
    protected function validateLogin(Request $request){
        //validar el inicio de sesion del usuario
        $this->validate($request,[
            'usuario'   =>  'required|alpha_num',
            'password'  =>  'required|alpha_num',
        ]);
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
