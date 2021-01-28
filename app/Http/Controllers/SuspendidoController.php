<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Suspendido;
use App\Miembro;
use Carbon\Carbon;
class SuspendidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $suspendidos = Suspendido:: orderBy('id','desc')->get();
        return[
            'suspendidos'=>$suspendidos,
        ];
    }
    //Miembro suspedido

    public function miembroSuspedido(Request $request){
        if(!$request->ajax()) return redirect('/');
        $ID = $request->ID;
        $suspendido = Suspendido:: where('ID_Miembro','=',$ID)
        ->orderBy('id','desc')->limit(1)->get();
        return[
            'suspendido'=>$suspendido,
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
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
            $mytime = Carbon::now('America/Mexico_City');
            
            $suspension = Suspendido::findOrFail($request->ID);
            $suspension->Motivo      =   mb_strtoupper($request->Motivo);
            $suspension->FechaInactivo          =   $mytime->toDateString();
            $suspension->save();

            $miembro = Miembro::findOrFail($request->ID);
            $miembro->Condicion   =   0;
            $miembro->save();
            
       
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
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
           
        $valor= 1;
        $miembro = Miembro::findOrFail($request->ID);
        $miembro->Condicion           =   $valor;
        $miembro->save();

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
