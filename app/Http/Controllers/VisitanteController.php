<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitante;
use Illuminate\Support\Facades\Storage;
class VisitanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $visitantes = Visitante::orderBy('id','desc')->get();
        // $cont = ((int) Articulo::count())+1;
        return[
            // 'Numero_Articulo' => $cont,
            'visitantes'=>$visitantes
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $visitante                   =   new Visitante();
            $ruta = '';
            
            // Verificamos si hay un file con nombre File
            if ($request->hasFile('File')) {
                $img = $request->file('File');
                $ruta = time().'_'.$img->getClientOriginalName();
                Storage::disk('img')->put($ruta,file_get_contents($img->getRealPath()));   
            }
            $visitante->Nombre           =   $request->Nombre;
            $visitante->Apellido_P      =   $request->Apellido_P;
            $visitante->Apellido_M          =   $request->Apellido_M;
            $visitante->Correo            =   $request->Correo;
            $visitante->Telefono            =   $request->Telefono;
            $visitante->Congregacion            =   $request->Congregacion;
            $visitante->RedSocial            =   $request->RedSocial;
            $visitante->Imagen           =   $ruta;
            $visitante->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
           
        $visitante = Visitante::findOrFail($request->ID);
            $visitante->Nombre           =   $request->Nombre;
            $visitante->Apellido_P      =   $request->Apellido_P;
            $visitante->Apellido_M          =   $request->Apellido_M;
            $visitante->Correo            =   $request->Correo;
            $visitante->Telefono            =   $request->Telefono;
            $visitante->Congregacion            =   $request->Congregacion;
            $visitante->RedSocial            =   $request->RedSocial;
            $visitante->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
