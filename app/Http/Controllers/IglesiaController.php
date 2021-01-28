<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Iglesia;
use App\Miembro;
use App\Contacto;
class IglesiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $decesos = Iglesia::join('contactos','contactos.ID_Miembro','=','iglesias.ID_Miembro')
        ->join('miembros','miembros.id','=','iglesias.ID_Miembro')
        ->where('iglesias.Deceso','=','0')
        ->orderBy('iglesias.id','desc')->get();
        // $cont = ((int) Articulo::count())+1;
        return[
            // 'Numero_Articulo' => $cont,
            'decesos'=>$decesos
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
        //
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
        $iglesia = Iglesia::findOrFail($request->ID);
        $iglesia->Deceso           =   0;
        $iglesia->FechaDeceso           =   $request->FechaDeceso;
        $iglesia->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }
}
