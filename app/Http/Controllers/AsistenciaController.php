<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Asistencia;
use App\Miembro;
use App\Contacto;
use App\Iglesia;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $mytime = Carbon::now('America/Mexico_City');
        $ID= $request->ID;
        $Fecha= $mytime->toDateString();
        $lista = Asistencia::
        where('ID_Miembro','=',$ID)
        ->where('Condicion','=','1')
        ->whereDate('Fecha',$Fecha)
        ->orderBy('id','desc')->get();
        return[
            'lista'=>$lista
        ];
        
    }
    public function listarAsistencias(Request $request){
        if(!$request->ajax()) return redirect('/');
        $mytime = Carbon::now('America/Mexico_City');
        $Fecha= $mytime->toDateString();
        $asistencias = Asistencia::join('miembros','miembros.id','=','asistencias.ID_Miembro')
        ->join('contactos','contactos.ID_Miembro','=','miembros.id')
        ->join('iglesias','iglesias.ID_Miembro','=','contactos.ID_Miembro')
        ->where('asistencias.Fecha','=',$Fecha)
        ->whereNull('iglesias.Deceso')
        ->orderBy('miembros.id','desc')->get();
        // $cont = ((int) Articulo::count())+1;
        return[
            // 'Numero_Articulo' => $cont,
            'asistencias'=>$asistencias
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
        //SE implementa un capturador de excepciones
        try {
            $mytime = Carbon::now('America/Mexico_City');
            //Se utilizaran transacciones
            DB::beginTransaction();
            $asistencia                   =   new Asistencia();
            $asistencia->ID_Miembro         =   $request->ID;
            $asistencia->Condicion          =   1;
            $asistencia->Fecha              =   $mytime->toDateTimeString();
            $asistencia->save();
            DB::commit();
        } catch (Exception $th) {
            //throw $th;
            DB::rollBack();
        }
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
    public function update(Request $request, $id)
    {
        //
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
