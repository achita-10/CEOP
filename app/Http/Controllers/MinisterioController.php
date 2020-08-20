<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ministerio;
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
        $ministerios = Ministerio::orderBy('id','desc')->get();
        return[
            'ministerios'=>$ministerios
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
        $mytime = Carbon::now('America/Mexico_City');
        if(!$request->ajax()) return redirect('/');
        $ministerio = new Ministerio();
        
        $ministerio->Nombre      =   $request->Nombre;
        $ministerio->Encargado =   $request->Encargado;
        $ministerio->Fecha       =  $mytime->toDateTimeString();
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
        
        $ministerio->Nombre      =   $request->Nombre;
        $ministerio->Encargado =   $request->Encargado;
        $ministerio->save();
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
