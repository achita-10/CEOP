<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ministerio;
use App\Miembros;
use Carbon\Carbon;
class MinisterioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $ministerios = Ministerio::join('miembros','ministerios.Encargado','=','miembros.id')
        ->select('ministerios.id','ministerios.Nombre as Ministerio','miembros.Nombre as Encargado','ministerios.Fecha','ministerios.Encargado as ID_E','miembros.Apellido_P','miembros.Apellido_M')
        ->orderBy('ministerios.id','desc')->get();
        return[
            'ministerios'=>$ministerios
        ];
    }
    public function pdf(Request $request)
    {
        $mytime = Carbon::now('America/Mexico_City');
        $Fecha = $mytime->toDateString();
        $ministerios = Ministerio::join('miembros','ministerios.Encargado','=','miembros.id')
        ->select('ministerios.id','ministerios.Nombre as NombreS','miembros.Nombre as Encargado','ministerios.Fecha','ministerios.Encargado as ID_E','miembros.Apellido_P','miembros.Apellido_M')
        ->orderBy('ministerios.id','desc')->get();
        $cont = ((int) Ministerio::count());
        $pdf = \PDF::loadView('pdf.GruposMinisterios',['Accion'=>2,'datos'=>$ministerios,'Total'=>$cont,'Fecha'=>$Fecha]);
        //Horientacion
        $pdf->setPaper('A4', 'landscape');
        //portrait, landscape
        //Metodo para visualizar desde el navegador sin descargar el archivo
        return $pdf->stream('Ministerios_'.$Fecha.'.pdf');
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
        $mytime = Carbon::now('America/Mexico_City');
        if(!$request->ajax()) return redirect('/');
        $ministerio = new Ministerio();
        // El metodo mb_strtoupper permite convertir a mayuculas carcteres especiales como la ñ
        $ministerio->Nombre      =   mb_strtoupper($request->Nombre);
        $ministerio->Encargado =   strtoupper($request->Encargado);
        $ministerio->Fecha       =  $mytime->toDateString();
        $ministerio->save();
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
        $ministerio = Ministerio::findOrFail($request->ID);
        // El metodo mb_strtoupper permite convertir a mayuculas carcteres especiales como la ñ
        $ministerio->Nombre      =   mb_strtoupper($request->Nombre);
        $ministerio->Encargado =   strtoupper($request->Encargado);
        $ministerio->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $id = $request->id;
        $eliminado = Ministerio:: where('id','=',$id)->delete();
    }
}
