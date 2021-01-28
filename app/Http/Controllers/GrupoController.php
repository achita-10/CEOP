<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;
use App\Ministerio;
use App\Miembro;
use App\Asistencia;
use Carbon\Carbon;
class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $grupos = Grupo::join('miembros','grupos.Encargado','=','miembros.id')
        ->select('grupos.id','grupos.Nombre as Grupo','miembros.Nombre as Encargado','grupos.Fecha','grupos.Encargado as ID_E','miembros.Apellido_P','miembros.Apellido_M')
        ->orderBy('grupos.id','desc')->get();
        return[
            'grupos'=>$grupos
        ];
    }
    public function pdf(Request $request)
    {
        $mytime = Carbon::now('America/Mexico_City');
        $Fecha = $mytime->toDateString();
        $grupos = Grupo::join('miembros','grupos.Encargado','=','miembros.id')
        ->select('grupos.id','grupos.Nombre as NombreS','miembros.Nombre as Encargado','grupos.Fecha','grupos.Encargado as ID_E','miembros.Apellido_P','miembros.Apellido_M')
        ->orderBy('grupos.id','desc')->get();
        $cont = ((int) Grupo::count());
        $pdf = \PDF::loadView('pdf.GruposMinisterios',['Accion'=>1,'datos'=>$grupos,'Total'=>$cont,'Fecha'=>$Fecha]);
        //Horientacion
        $pdf->setPaper('A4', 'landscape');
        //portrait, landscape
        //Metodo para visualizar desde el navegador sin descargar el archivo
        return $pdf->stream('Grupos_'.$Fecha.'.pdf');
    }
    public function verificarAsistencia(Request $request){
        if(!$request->ajax()) return redirect('/');
        $Fecha = $request->Fecha;
        $Grupo = $request->Grupo;
        $Trimestre = $request->Trimestre;
        $Inicio="";
        $Fin="";
        
        if($Trimestre=='1'){
            $Inicio=$Fecha.'-01-01';
            $Fin=$Fecha.'-03-31';
        }else if($Trimestre=='2'){
            $Inicio=$Fecha.'-04-01';
            $Fin=$Fecha.'-06-30';
        }else if($Trimestre=='3'){
            $Inicio=$Fecha.'-07-01';
            $Fin=$Fecha.'-09-30';
        }else{
            $Inicio=$Fecha.'-10-01';
            $Fin=$Fecha.'-12-31';
        }
        // print_r($Trimestre);
        // print_r($Fecha);
        // print_r($Fin);
        // var_dump($Inicio);
        
        $datos = Miembro::join('asistencias','asistencias.ID_Miembro','=','miembros.id')
        ->where('asistencias.Condicion','=','1')
        ->where('miembros.Condicion','=','1')
        ->where('miembros.Grupo','=',$Grupo)
        ->whereBetween('asistencias.Fecha',[$Inicio, $Fin])
        ->orderBy('miembros.id','desc')
        ->get();
        return [
            'asistencias'=>$datos
        ];
    }
    public function pdfAsistencia(Request $request){
        $filtro=[];
        $Fecha = $request->Fecha;
        $Grupo = $request->Grupo;
        $Trimestre = $request->Trimestre;

        $Inicio="";
        $Fin="";

        if($Trimestre=='1'){
            $Inicio=$Fecha.'-01-01';
            $Fin=$Fecha.'-03-31';
        }else if($Trimestre=='2'){
            $Inicio=$Fecha.'-04-01';
            $Fin=$Fecha.'-06-30';
        }else if($Trimestre=='3'){
            $Inicio=$Fecha.'-07-01';
            $Fin=$Fecha.'-09-30';
        }else{
            $Inicio=$Fecha.'-10-01';
            $Fin=$Fecha.'-12-31';
        }
        $ministerios = Ministerio::orderBy('id','desc')->get();
        $grupos = Grupo::orderBy('id','desc')->get();
        $miembros = Miembro::
        where('Condicion','=','1')
        ->where('Grupo','=',$Grupo)
        ->orderBy('id','desc')
        ->get();
        $asistencias = Asistencia::where('Condicion','=','1')
        ->whereBetween('Fecha',[$Inicio, $Fin])
        ->orderBy('id','asc')
        ->get();
        $encargado = Grupo::join('miembros','grupos.Encargado','=','miembros.id')
        ->select('grupos.Nombre as NombreS','miembros.Nombre as Encargado','miembros.Apellido_P','miembros.Apellido_M')
        ->where('grupos.id','=',$Grupo)
        ->orderBy('grupos.id','desc')->get();
        $cont = ((int) count($miembros));
        $pdf = \PDF::loadView('pdf.asistencia',['Total'=>$cont,'Asistencias'=>$asistencias,'Encargado'=>$encargado,'Fecha'=>$Fecha,'Miembros'=>$miembros,'Trimestre'=>$Trimestre,'Grupos'=>$grupos,'Ministerios'=>$ministerios]);
        //Horientacion
        $pdf->setPaper('A4', 'portrait');
        //portrait, landscape
        //Metodo para visualizar desde el navegador sin descargar el archivo
        return $pdf->stream('Asistencias.pdf');

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
        $grupo = new Grupo();
        // El metodo mb_strtoupper permite convertir a mayuculas carcteres especiales como la ñ
        $grupo->Nombre      =   mb_strtoupper($request->Nombre);
        $grupo->Encargado =   strtoupper($request->Encargado);
        $grupo->Fecha       =  $mytime->toDateString();
        $grupo->save();
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
        $grupo = Grupo::findOrFail($request->ID);
        // El metodo mb_strtoupper permite convertir a mayuculas carcteres especiales como la ñ
        $grupo->Nombre      =   mb_strtoupper($request->Nombre);
        $grupo->Encargado =   strtoupper($request->Encargado);
        $grupo->save();
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
        $eliminado = Grupo:: where('id','=',$id)->delete();
        

    }
}
