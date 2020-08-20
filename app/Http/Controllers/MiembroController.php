<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Miembro;
use App\Contacto;
use App\Iglesia;
use Carbon\Carbon;
class MiembroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $miembros = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
        ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
        
        ->orderBy('miembros.id','desc')->get();
        // $cont = ((int) Articulo::count())+1;
        return[
            // 'Numero_Articulo' => $cont,
            'miembros'=>$miembros
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
    public function datosMiembro(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id =   $request->id;
        $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
        ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
        ->where('miembros.id','=',$id)
        ->orderBy('miembros.id','desc')->get();
        // $cont = ((int) Articulo::count())+1;
        return[
            // 'Numero_Articulo' => $cont,
            'datos'=>$datos
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
            $mytime = Carbon::now('America/Mexico_City');
            //Se utilizaran transacciones
            DB::beginTransaction();
            $miembro                   =   new Miembro();
            $ruta = '';
            
            // Verificamos si hay un file con nombre File
            if ($request->hasFile('File')) {
                $img = $request->file('File');
                $ruta = time().'_'.$img->getClientOriginalName();
                Storage::disk('img')->put($ruta,file_get_contents($img->getRealPath()));   
            }
            $miembro->Nombre           =   $request->Nombre;
            $miembro->Apellido_P      =   $request->Apellido_P;
            $miembro->Apellido_M          =   $request->Apellido_M;
            $miembro->Genero            =   $request->Genero;
            $miembro->EstadoCivil            =   $request->EstadoCivil;
            $miembro->FechaNac            =   $request->FechaNac;
            $miembro->Imagen           =   $ruta;
            $miembro->save();

           
            $contacto = new Contacto();
            $contacto->ID_Miembro       =   $miembro->id;
            $contacto->Correo           =   $request->Correo;
            $contacto->Telefono         =   $request->Telefono;
            $contacto->Direccion        =   $request->Direccion;
            $contacto->Ocupacion        =   $request->Ocupacion;
            $contacto->Padre            =   $request->Padre;
            $contacto->Madre            =   $request->Madre;
            $contacto->save();

            $iglesia = new Iglesia();
            $iglesia->ID_Miembro       =   $miembro->id;
            $iglesia->FechaIngreso           =   $request->FechaIngreso;
            $iglesia->FechaConversion         =   $request->FechaConversion;
            $iglesia->Bautizado        =   $request->Bautizado;
            $iglesia->FechaBautizo        =   $request->FechaBautizo;
            $iglesia->Iglesia            =   $request->Iglesia;
            $iglesia->Grupo            =   $request->Grupo;
            $iglesia->Ministerio            =   $request->Ministerio;
            $iglesia->FechaDeceso            =   $request->FechaDeceso;
            $iglesia->save();



            DB::commit();
        } catch (Exception $th) {
            //throw $th;
            DB::rollBack();
        }
        
    }

    public function actualizarImagen(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $miembro = Miembro::findOrFail($request->ID);
        $ruta = '';
 
        // Verificamos si hay un file con nombre File
        if ($request->hasFile('File')) {
            $img = $request->file('File');
            $ruta = time().'_'.$img->getClientOriginalName();
            Storage::disk('img')->put($ruta,file_get_contents($img->getRealPath()));   
            
        }
        $miembro->Imagen           =   $ruta;
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
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
           
        $miembro = Miembro::findOrFail($request->ID);
            $miembro->Nombre           =   $request->Nombre;
            $miembro->Apellido_P      =   $request->Apellido_P;
            $miembro->Apellido_M          =   $request->Apellido_M;
            $miembro->Genero            =   $request->Genero;
            $miembro->EstadoCivil            =   $request->EstadoCivil;
            $miembro->FechaNac            =   $request->FechaNac;
            $miembro->save();

           
        $contacto = Contacto::findOrFail($request->ID);
            $contacto->ID_Miembro       =   $miembro->id;
            $contacto->Correo           =   $request->Correo;
            $contacto->Telefono         =   $request->Telefono;
            $contacto->Direccion        =   $request->Direccion;
            $contacto->Ocupacion        =   $request->Ocupacion;
            $contacto->Padre            =   $request->Padre;
            $contacto->Madre            =   $request->Madre;
            $contacto->save();

        $iglesia = Iglesia::findOrFail($request->ID);
            $iglesia->ID_Miembro       =   $miembro->id;
            $iglesia->FechaIngreso           =   $request->FechaIngreso;
            $iglesia->FechaConversion         =   $request->FechaConversion;
            $iglesia->Bautizado        =   $request->Bautizado;
            $iglesia->FechaBautizo        =   $request->FechaBautizo;
            $iglesia->Iglesia            =   $request->Iglesia;
            $iglesia->Grupo            =   $request->Grupo;
            $iglesia->Ministerio            =   $request->Ministerio;
            $iglesia->FechaDeceso            =   $request->FechaDeceso;
            $iglesia->save();

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
