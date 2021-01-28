<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Miembro;
use App\Contacto;
use App\Iglesia;
use App\Asistencia;
use App\Grupo;
use App\Ministerio;
use App\Suspendido;
use Carbon\Carbon;
class MiembroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //NOTA........

     //Cuando se suban los archivos al servidor hostinger, poner en minusculas todos los nombres de las tablas
     //de lo contrario no podran ejecutarce correctamente las consultas
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $miembros = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
        ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
        ->join('suspendidos','suspendidos.ID_Miembro','=','miembros.id')
        ->where('miembros.Condicion','=','1')
        ->whereNull('iglesias.Deceso')
        ->orderBy('miembros.id','desc')->get();
        // $cont = ((int) Articulo::count())+1;
        return[
            // 'Numero_Articulo' => $cont,
            'miembros'=>$miembros
        ];
    }
    public function pdfIntegrantes(Request $request){
        $mytime = Carbon::now('America/Mexico_City');
        $Fecha = $mytime->toDateString();
        $cadena="";
        if($request->Tipo=="1"){
            $cadena ="Ministerio";
            $tipo = Ministerio::orderBy('id','desc')->get();
            $datos = Ministerio::join('miembros','ministerios.Encargado','=','miembros.id')
            ->select('ministerios.id','ministerios.Nombre as NombreS','miembros.Nombre as Encargado','ministerios.Fecha','ministerios.Encargado as ID_E','miembros.Apellido_P','miembros.Apellido_M')
            ->where("ministerios.id",'=',$request->Ministerio)
            ->orderBy('ministerios.id','desc')->get();
        }else{
            $cadena = "Grupo";
            $tipo = Grupo::orderBy('id','desc')->get();
            $datos = Grupo::join('miembros','grupos.Encargado','=','miembros.id')
            ->select('grupos.id','grupos.Nombre as NombreS','miembros.Nombre as Encargado','grupos.Fecha','grupos.Encargado as ID_E','miembros.Apellido_P','miembros.Apellido_M')
            ->where("grupos.id",'=',$request->Ministerio)
            ->orderBy('grupos.id','desc')->get();

        }
        
        $miembros = Miembro::where($cadena,'=',$request->Ministerio)
        ->where("Condicion",'=',"1")
        ->orderBy('id','desc')->get();
        $cont = ((int) count($miembros));
        $pdf = \PDF::loadView('pdf.IntegrantesGM',["Ministerio"=>$datos,'Tipo'=>$tipo,'datos'=>$miembros,'Total'=>$cont,'Fecha'=>$Fecha]);
        //Horientacion
        $pdf->setPaper('A4', 'landscape');
        //portrait, landscape
        //Metodo para visualizar desde el navegador sin descargar el archivo
        return $pdf->stream('Ministerios_'.$Fecha.'.pdf');
    }
    //departamento activo
    public function activoDepartamento(Request $request){
        if(!$request->ajax()) return redirect('/');
        $Departamento = $request->Departamento;
        $Tipo= $request->Tipo;
        $campo = '';
        if($Tipo=='1'){
            $campo = 'Grupo';
        }else{
            $campo='Ministerio';
        }
        $miembros=Miembro:: where($campo,'=',$Departamento)->get();
        return [
            'miembros'=> $miembros
        ];
        
    }
    //grupo o ministerio  activo
    public function activoCampo(Request $request){
        if(!$request->ajax()) return redirect('/');
        $Nombre = $request->Nombre;
        $Tipo   =   $request->Tipo;
        $campo = '';
        if($Tipo=='1'){
            $campo = 'Grupo';
        }else{
            $campo='Ministerio';
        }
        $miembro = Miembro::join('iglesias','iglesias.id','=','miembros.id')
        ->whereNull('iglesias.Deceso')
        ->where('miembros.'.$campo,'=',$Nombre)
        ->where('miembros.Condicion','=','1')
        ->orderBy('miembros.id','desc')->get();
        return[
            'miembros'=>$miembro
        ];
    }
    //PDF 
    public function pdfRango(Request $request){
        $Total=0;
        $Fecha=explode(",", $request->Fechas);
        $Tipo= $request->Tipo;
        $Inicio=$Fecha[0];
        $Fin=$Fecha[1];
        $Fechas=[
            'Inicio'=>$Inicio,
            'Fin' => $Fin
        ];
        
        $ministerios = Ministerio::orderBy('id','desc')->get();
        $grupos = Grupo::orderBy('id','desc')->get();
        if($Tipo=='0'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','1')
            ->orderBy('miembros.id','desc')
            ->whereBetween('iglesias.FechaBautizo', [$Inicio, $Fin])
            ->get();
            $Tipo='Bautizados';
            $Total = (int) count($datos);
        }else if($Tipo=='1'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','2')
            ->orderBy('miembros.id','desc')
            ->whereBetween('miembros.FechaIngreso', [$Inicio, $Fin])
            ->get();
            $Tipo='NoBautizados';
            $Total = (int) count($datos);
        }else if($Tipo=='2'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Deceso','=','0')
            ->whereBetween('iglesias.FechaDeceso', [$Inicio, $Fin])
            ->orderBy('miembros.id','desc')
            ->get();
            $Tipo='Fallecidos';
            $Total = (int) count($datos);
        }else if($Tipo=='4'){
            $datos = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','1')
            ->whereNull('iglesias.Deceso')
            ->whereBetween('miembros.FechaIngreso', [$Inicio, $Fin])
            ->orderBy('miembros.id','desc')
            ->get();
            $Total = (int) count($datos);
        }else if($Tipo=='5'){
            $datos = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','0')
            ->whereNull('iglesias.Deceso')
            ->whereBetween('miembros.FechaIngreso', [$Inicio, $Fin])
            ->orderBy('miembros.id','desc')
            ->get();
            $Total = (int) count($datos);
        }else{
            $separai = explode('-',$Inicio);
            $diai= $separai[2];
            $mesi= $separai[1];
            $separaf = explode('-',$Fin);
            $diaf= $separaf[2];
            $mesf= $separaf[1];
            $datos=[];
            $consulta = Miembro::
            orderBy('id','desc')
            ->get();
            foreach ($consulta as $key) {
                $Fecha = $key->FechaNac;
                $separar = explode('-',$Fecha);
                $dia = $separar[2];
                $mes= $separar[1];
                if(($dia>=$diai && $mes>=$mesi) && ($dia<=$diaf && $mes<=$mesf)){
                    $arreglo = (object)[
                        'id' => $key->id,
                        'Nombre' => $key->Nombre,
                        'Apellido_P' => $key->Apellido_P,
                        'Apellido_M' => $key->Apellido_M,
                        'Genero' => $key->Genero,
                        'EstadoCivil' => $key->EstadoCivil,
                        'FechaNac' => $key->FechaNac,
                        'FechaIngreso' => $key->FechaIngreso,
                        'Imagen' => $key->Imagen
                    ];
                    array_push($datos, $arreglo);
                }
            }
            $Tipo='Cumpleaños';
            $Total = (int) count($datos);
        }
        if($Tipo=='4' || $Tipo=='5'){
            $pdf = \PDF::loadView('pdf.Miembros',['Total'=>$Total,'Accion'=>1,'Tipo'=>$Tipo,'datos'=>$datos,'Inicio'=>$Inicio,'Fin'=>$Fin,'Ministerios'=>$ministerios,'Grupos'=>$grupos]);
        }else{
            $pdf = \PDF::loadView('pdf.reporte',['Total'=>$Total,'Accion'=>1,'datos'=>$datos,'Inicio'=>$Inicio,'Fin'=>$Fin,'Tipo'=>$Tipo,'Ministerios'=>$ministerios,'Grupos'=>$grupos]);
        }
        //Horientacion
        $pdf->setPaper('A4', 'landscape');
        //portrait, landscape
        //Metodo para visualizar desde el navegador sin descargar el archivo
        return $pdf->stream($Tipo.'_'.$Inicio.'_'.$Fin.''.'.pdf');
    }
    public function pdfDia(Request $request){
        $Fecha = $request->Fecha;
        $Tipo= $request->Tipo;
        
        $ministerios = Ministerio::orderBy('id','desc')->get();
        $grupos = Grupo::orderBy('id','desc')->get();
        if($Tipo=='0'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','1')
            ->where('iglesias.FechaBautizo','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
            $Tipo='Bautizados';
            $Total = (int) count($datos);
        }else if($Tipo=='1'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','2')
            ->where('miembros.FechaIngreso','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
            $Tipo='NoBautizados';
            $Total = (int) count($datos);
        }else if($Tipo=='2'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Deceso','=','0')
            ->where('iglesias.FechaDeceso','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
            $Tipo='Fallecidos';
            $Total = (int) count($datos);
        }else if($Tipo=='4'){
            $datos = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','1')
            ->whereNull('iglesias.Deceso')
            ->where('miembros.FechaIngreso','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
            $Total = (int) count($datos);
        }else if($Tipo=='5'){
            $datos = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','0')
            ->whereNull('iglesias.Deceso')
            ->where('miembros.FechaIngreso','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
            $Total = (int) count($datos);
        }else{
            $separar= explode('-',$Fecha);
            $dia = $separar[2];
            $datos = Miembro::whereDay('FechaNac',$dia)
            ->orderBy('id','desc')
            ->get();
            $Tipo='Cumpleaños';
            $Total = (int) count($datos);
        }
        if($Tipo=='4' || $Tipo=='5'){
            $pdf = \PDF::loadView('pdf.Miembros',['Total'=>$Total,'Accion'=>2,'Tipo'=>$Tipo,'datos'=>$datos,'Fecha'=>$Fecha,'Ministerios'=>$ministerios,'Grupos'=>$grupos]);
        }else{
            $pdf = \PDF::loadView('pdf.reporte',['Total'=>$Total,'Accion'=>2,'datos'=>$datos,'Fecha'=>$Fecha,'Tipo'=>$Tipo,'Ministerios'=>$ministerios,'Grupos'=>$grupos]);
        }
        //Horientacion
        $pdf->setPaper('A4', 'landscape');
        //portrait, landscape
        //Metodo para visualizar desde el navegador sin descargar el archivo
        return $pdf->stream($Tipo.'_'.$Fecha.'.pdf');
    }
    public function pdfSinFecha(Request $request){
        $Total=0;
        $Antiguedad=[];
        $Tipo= $request->Tipo;
        $mytime = Carbon::now('America/Mexico_City');
        $Fecha = $mytime->toDateString();
        $ministerios = Ministerio::orderBy('id','desc')->get();
        $grupos = Grupo::orderBy('id','desc')->get();
        if($Tipo=='0'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','1')
            ->orderBy('miembros.id','desc')
            ->get();
            $Tipo='Bautizados';
            $Total = (int) count($datos);
        }else if($Tipo=='1'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','2')
            ->orderBy('miembros.id','desc')
            ->get();
            $Tipo='NoBautizados';
            $Total = (int) count($datos);
        }else if($Tipo=='2'){
            $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Deceso','=','0')
            ->orderBy('miembros.id','desc')
            ->get();
            $Tipo='Fallecidos';
            $Total = (int) count($datos);
        }else if($Tipo=='4'){
            $datos = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','1')
            ->whereNull('iglesias.Deceso')
            ->orderBy('miembros.id','desc')
            ->get();
            $Total = (int) count($datos);
        }else if($Tipo=='5'){
            $datos = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->join('suspendidos','suspendidos.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','0')
            ->whereNull('iglesias.Deceso')
            ->orderBy('miembros.id','desc')
            ->get();
            $Total = (int) count($datos);
        }else{
            $separar= explode('-',$Fecha);
            $dia = $separar[2];
            $datos = Miembro::whereDay('FechaNac',$dia)
            ->orderBy('id','desc')
            ->get();
            $Tipo='Cumpleaños';
            $Total = (int) count($datos);
        }
        if($Tipo=='4' || $Tipo=='5'){
            $pdf = \PDF::loadView('pdf.Miembros',['Total'=>$Total,'Accion'=>3,'Tipo'=>$Tipo,'datos'=>$datos,'Fecha'=>$Fecha,'Ministerios'=>$ministerios,'Grupos'=>$grupos]);
        }else{
            $pdf = \PDF::loadView('pdf.reporte',['Total'=>$Total,'Accion'=>3,'datos'=>$datos,'Tipo'=>$Tipo,'Ministerios'=>$ministerios,'Grupos'=>$grupos]);
        }
        //Horientacion
        $pdf->setPaper('A4', 'landscape');
        //portrait, landscape
        //Metodo para visualizar desde el navegador sin descargar el archivo
        return $pdf->stream($Tipo.'.pdf');
    }
    public function validar($dias){
        $valor ="";
        $contador=0;
        if($dias>=365){
            while ($dias > 365) {
                $dias = $dias-365;
                $contador++;
            }
            $dias = $dias-5;
            if($contador == 1){
                $valor = $contador." año ".$dias." dias";
            }else{
                $valor = $contador." años ".$dias." dias";
            }
        }else{
            $valor=$dias." dias";
        }
        
        return $valor;
    }
    public function pdfindividual(Request $request){
        $Edades=[];
        $Antiguedades=[];
        $contador=0;
        $mytime = Carbon::now('America/Mexico_City');
        $Fecha = $mytime->toDateString();
        $ministerios = Ministerio::orderBy('id','desc')->get();
        $grupos = Grupo::orderBy('id','desc')->get();
        $ID = $request->ID;
        $datos = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->join('suspendidos','suspendidos.ID_Miembro','=','miembros.id')
            ->where('miembros.id','=',$ID)
            ->orderBy('miembros.id','desc')
            ->get();
        foreach ($datos as $key ) {
            $edad = \Carbon\Carbon::parse($key->FechaNac)->age;
            $arreglo = (object)[
                'id'=>$key->id,
                'Edad'=>$edad
            ];
            array_push($Edades,$arreglo);
        }
        foreach ($datos as $key ) {
            $dias = (strtotime($key->FechaIngreso)-strtotime($Fecha))/86400;
            $dias = abs($dias); 
            $dias = floor($dias);
            $valor = $this->validar($dias);
            $arreglo = (object)[
                'id'=>$key->id,
                'Antiguedad'=>$valor
            ];
            array_push($Antiguedades,$arreglo);
        }
        $Total = (int) count($datos);
        $pdf = \PDF::loadView('pdf.miembro',['Antiguedades'=>$Antiguedades,'Edades'=>$Edades,'datos'=>$datos,'Fecha'=>$Fecha,'Ministerios'=>$ministerios,'Grupos'=>$grupos]);
        //Horientacion
        $pdf->setPaper('A4', 'portrait');
        //portrait, landscape
        //Metodo para visualizar desde el navegador sin descargar el archivo
        return $pdf->stream('Miembro_'.$Fecha.'.pdf');
    }
    
    //FILTROS
    public function filtradoBautizos(Request $request){
        $Inicio =   $request->Inicio;
        $Fin =   $request->Fin;
        $Tipo = $request->Tipo;
        if($Tipo=='3'){
            if(!$request->ajax()) return redirect('/');
            $separai = explode('-',$Inicio);
            $diai= $separai[2];
            $mesi= $separai[1];
            $separaf = explode('-',$Fin);
            $diaf= $separaf[2];
            $mesf= $separaf[1];
            $rango=[];
            $consulta = Miembro::
            orderBy('id','desc')
            ->get();
            foreach ($consulta as $key) {
                $Fecha = $key->FechaNac;
                $separar = explode('-',$Fecha);
                $dia = $separar[2];
                $mes= $separar[1];
                if(($dia>=$diai && $mes>=$mesi) && ($dia<=$diaf && $mes<=$mesf)){
                    $arreglo = (object)[
                        'id' => $key->id,
                        'Nombre' => $key->Nombre,
                        'Apellido_P' => $key->Apellido_P,
                        'Apellido_M' => $key->Apellido_M,
                        'Genero' => $key->Genero,
                        'EstadoCivil' => $key->EstadoCivil,
                        'FechaNac' => $key->FechaNac,
                        'FechaIngreso' => $key->FechaIngreso,
                        'Imagen' => $key->Imagen
                    ];
                    array_push($rango, $arreglo);
                }
            }
        }else if($Tipo=='5'){
            if(!$request->ajax()) return redirect('/');
            $rango = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','0')
            ->whereNull('iglesias.Deceso')
            ->whereBetween('miembros.FechaIngreso', [$Inicio, $Fin])
            ->orderBy('miembros.id','desc')
            ->get();
        }else if($Tipo=='4'){
            if(!$request->ajax()) return redirect('/');
            $rango = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','1')
            ->whereNull('iglesias.Deceso')
            ->whereBetween('miembros.FechaIngreso', [$Inicio, $Fin])
            ->orderBy('miembros.id','desc')
            ->get();
        }else if($Tipo=='2'){
            if(!$request->ajax()) return redirect('/');
            $rango = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->whereBetween('iglesias.FechaDeceso', [$Inicio, $Fin])
            ->where('iglesias.Deceso','=','0')
            ->orderBy('miembros.id','desc')
            ->get();
        }else if($Tipo=='1'){
            if(!$request->ajax()) return redirect('/');
            $rango = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','2')
            ->whereBetween('miembros.FechaIngreso', [$Inicio, $Fin])
            ->orderBy('miembros.id','desc')
            ->get();
        }else{
            if(!$request->ajax()) return redirect('/');
            $rango = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','1')
            ->whereBetween('iglesias.FechaBautizo', [$Inicio, $Fin])
            ->orderBy('miembros.id','desc')
            ->get();
        }
        return[
            'rango'=>$rango
        ];
        
    }
    public function diaBautizos(Request $request){
        $Fecha =   $request->Dia;
        $Tipo =   $request->Tipo;
        if($Tipo=='3'){
            $separar = explode('-',$Fecha);
            $fechadia = $separar[2];
            $fechames = $separar[1];
            if(!$request->ajax()) return redirect('/');
            $dia = Miembro::
            whereDay('FechaNac',$fechadia)
            ->whereMonth('FechaNac', $fechames)
            ->orderBy('id','desc')
            ->get();
            
        }else if($Tipo=='5'){
            if(!$request->ajax()) return redirect('/');
            $dia = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','0')
            ->whereNull('iglesias.Deceso')
            ->where('miembros.FechaIngreso','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
        }else if($Tipo=='4'){
            if(!$request->ajax()) return redirect('/');
            $dia = Miembro::join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('miembros.Condicion','=','1')
            ->whereNull('iglesias.Deceso')
            ->where('miembros.FechaIngreso','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
        }else if($Tipo=='2'){
            if(!$request->ajax()) return redirect('/');
            $dia = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Deceso','=','0')
            ->where('iglesias.FechaDeceso','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();  
        }else if($Tipo=='1'){
            if(!$request->ajax()) return redirect('/');
            $dia = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','2')
            ->where('miembros.FechaIngreso','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
        }else{
            if(!$request->ajax()) return redirect('/');
            $dia = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
            ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
            ->where('iglesias.Bautizado','=','1')
            ->where('iglesias.FechaBautizo','=',$Fecha)
            ->orderBy('miembros.id','desc')
            ->get();
        }
        return[
            'dia'=>$dia
        ];
        
    }
    public function bautizados(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $miembros = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
        ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
        ->where('iglesias.Bautizado','=','1')
        ->whereNull('iglesias.Deceso')
        ->orderBy('miembros.id','desc')->get();
        return[
            'bautizados'=>$miembros
        ];
    }
    public function nobautizados(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $miembros = Miembro::join('contactos','contactos.ID_Miembro','=','miembros.id')
        ->join('iglesias','iglesias.ID_Miembro','=','miembros.id')
        ->where('iglesias.Bautizado','=','2')
        ->whereNull('iglesias.Deceso')
        ->orderBy('miembros.id','desc')->get();
        // $cont = ((int) Articulo::count())+1;
        return[
            // 'Numero_Articulo' => $cont,
            'nobautizados'=>$miembros
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
            $miembro->Nombre           =   mb_strtoupper($request->Nombre);
            $miembro->Apellido_P      =   mb_strtoupper($request->Apellido_P);
            $miembro->Apellido_M          =   mb_strtoupper($request->Apellido_M);
            $miembro->Genero            =   $request->Genero;
            $miembro->EstadoCivil            =   $request->EstadoCivil;
            $miembro->FechaNac            =   $request->FechaNac;
            $miembro->Grupo            =   $request->Grupo;
            $miembro->Ministerio            =   $request->Ministerio;
            $miembro->FechaIngreso           =   $request->FechaIngreso;
            $miembro->Imagen           =   $ruta;
            $miembro->Condicion         =   1;
            $miembro->save();

           
            $contacto = new Contacto();
            $contacto->ID_Miembro       =   $miembro->id;
            $contacto->Correo           =   $request->Correo;
            $contacto->Telefono         =   $request->Telefono;
            $contacto->Direccion        =   mb_strtoupper($request->Direccion);
            $contacto->Ocupacion        =   mb_strtoupper($request->Ocupacion);
            $contacto->Padre            =   mb_strtoupper($request->Padre);
            $contacto->Madre            =   mb_strtoupper($request->Madre);
            $contacto->save();

            $iglesia = new Iglesia();
            $iglesia->ID_Miembro       =   $miembro->id;
            $iglesia->FechaConversion         =   $request->FechaConversion;
            $iglesia->Bautizado        =   $request->Bautizado;
            $iglesia->FechaBautizo        =   $request->FechaBautizo;
            $iglesia->Iglesia            =   mb_strtoupper($request->Iglesia);
            $iglesia->FechaDeceso            =   $request->FechaDeceso;
            $iglesia->save();

            $suspension = new Suspendido();
            $suspension->ID_Miembro = $miembro->id;
            $suspension->save();



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
            $miembro->Nombre           =   mb_strtoupper($request->Nombre);
            $miembro->Apellido_P      =   mb_strtoupper($request->Apellido_P);
            $miembro->Apellido_M          =   mb_strtoupper($request->Apellido_M);
            $miembro->Genero            =   $request->Genero;
            $miembro->EstadoCivil            =   $request->EstadoCivil;
            $miembro->FechaNac            =   $request->FechaNac;
            $miembro->FechaIngreso            =   $request->FechaIngreso;
            $miembro->Grupo            =   $request->Grupo;
            $miembro->Ministerio            =   $request->Ministerio;
            $miembro->save();

           
        $contacto = Contacto::findOrFail($request->ID);
            $contacto->ID_Miembro       =   $miembro->id;
            $contacto->Correo           =   $request->Correo;
            $contacto->Telefono         =   $request->Telefono;
            $contacto->Direccion        =   mb_strtoupper($request->Direccion);
            $contacto->Ocupacion        =   mb_strtoupper($request->Ocupacion);
            $contacto->Padre            =   mb_strtoupper($request->Padre);
            $contacto->Madre            =   mb_strtoupper($request->Madre);
            $contacto->save();

        $iglesia = Iglesia::findOrFail($request->ID);
            $iglesia->ID_Miembro       =   $miembro->id;
            $iglesia->FechaConversion         =   $request->FechaConversion;
            $iglesia->Bautizado        =   $request->Bautizado;
            $iglesia->FechaBautizo        =   $request->FechaBautizo;
            $iglesia->Iglesia            =   mb_strtoupper($request->Iglesia);
            $iglesia->FechaDeceso            =   $request->FechaDeceso;
            $iglesia->save();

    }
    // public function desactivar(Request $request)
    // {
    //     if(!$request->ajax()) return redirect('/');
    //     $opcion = $request->opcion;
    //     $valor= 1;
    //     if($opcion=='1'){
    //         $valor=0;
    //     }
    //     $miembro = Miembro::findOrFail($request->id);
    //     $miembro->Condicion   =   $valor;
    //     $miembro->save();
    // }
    public function activo(Request $request){
        if(!$request->ajax()) return redirect('/');
        $miembroActivo = Miembro::
        join('iglesias','iglesias.ID_Miembro','=','miembros.id')
        ->join('contactos','contactos.ID_Miembro','=','miembros.id')
        ->where('Condicion','=','1')
        ->whereNull('iglesias.Deceso')
        ->orderBy('miembros.id','desc')->get();
        return[
            'activos' => $miembroActivo
        ];
    }
    public function inactivo(Request $request){
        if(!$request->ajax()) return redirect('/');
        $miembro = Miembro::
        join('iglesias','iglesias.ID_Miembro','=','miembros.id')
        ->where('miembros.Condicion','=','0')
        ->whereNull('iglesias.Deceso')
        ->orderBy('miembros.id','desc')->get();
        return[
            'inactivos' => $miembro
        ];
    }
    public function cumples(Request $request){
        if(!$request->ajax())return redirect('/');
        $fecha = Carbon::now('America/Mexico_City');
        $separar = explode('-',$fecha->toDateString());
        $dia= $separar[2];
        $mes= $separar[1];
        $cumpleaños = Miembro::
        whereDay('FechaNac',$dia)
        ->whereMonth('FechaNac', $mes)
        ->orderBy('id')
        ->get();
        return[
            'cumpleaños'=>$cumpleaños,
        ];
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
