<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias <?php echo "Trimestre ".$Trimestre." ".$Fecha;?></title>
    <style>
        /* spacing */

        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 3px solid #000000;
            font-size: x-small;
        }
        
        th, td {
            width: 25%;
            vertical-align: top;
            border: 1px solid #000;
            border-spacing: 0;
            padding: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Reporte Lista de Asistencia</h1>
    <h4><?php echo "Total de miembros: ".$Total;?></h4>
    @foreach($Encargado as $d)
        <div>
            <table>
                <thead>
                    <tr >
                        <td>Grupo: 
                            <strong>
                                {{$d->NombreS}}
                            </strong>          
                        </td>
                        <td>
                            Periodo: 
                            <strong>
                            <?php
                                if($Trimestre=='1'){
                                    echo $Fecha.'-01-01 - '.$Fecha.'-03-31';
                                }else if($Trimestre=='2'){
                                    echo $Fecha.'-04-01 - '.$Fecha.'-06-30';
                                }else if($Trimestre=='3'){
                                    echo $Fecha.'-07-01 - '.$Fecha.'-09-30';
                                }else{
                                    echo $Fecha.'-10-01 - '.$Fecha.'-12-31';
                                }
                            ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Encargado: 
                            <strong>
                            
                                {{$d->Encargado}} {{$d->Apellido_P}} {{$d->Apellido_M}}
                            
                            </strong>
                        </td>
                        <td>Trimestre: <strong><?php echo $Trimestre;?></strong></td>
                    </tr>
                </thead>
            </table>
        </div>
        <br>
    @endforeach
        <div>
            <table >
                <thead>
                    <tr id="fa" style="text-align:center;">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                    </tr>
                </thead>
                <tbody>
                <?php $contador=1; $verifica=0; $asis=0; $noasis=0;
                    foreach($Miembros as $m){ 
                        ?>
                        <tr style="text-align:center;">
                            <td><?php echo $contador;?></td>
                            <td><?php echo $m->Nombre;?></td>
                            <td><?php echo $m->Apellido_P;?></td>
                            <td><?php echo $m->Apellido_M;?></td>
                        </tr>
                        <tr>
                            <td colspan="4" >
                                <?php
                                    $fechaInicio="";
                                    $fechaFin="";
                                    $diaActual=strtotime("now");
                                    if($Trimestre=='1'){
                                        $fechaInicio = strtotime("01-01-".$Fecha);
                                        $fechaFin = strtotime("31-03-".$Fecha);
                                    }else if($Trimestre=='2'){
                                        $fechaInicio = strtotime("01-04-".$Fecha);
                                        $fechaFin = strtotime("30-06-".$Fecha);
                                    }else if($Trimestre=='3'){
                                        $fechaInicio = strtotime("01-07-".$Fecha);
                                        $fechaFin = strtotime("30-09-".$Fecha);
                                    }else{
                                        $fechaInicio = strtotime("01-10-".$Fecha);
                                        $fechaFin = strtotime("31-12-".$Fecha);
                                    }
                                    $clave =0; $asis=0; $noasis=0; $ultimaF=0; 
                                    
                                    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                        $ultimaF=$i;
                                        $dia =  date("l", $i);
                                        if($dia == 'Sunday'){
                                            
                                            $dia = date("Y-m-d", $i);
                                            echo $dia.": &nbsp;&nbsp;&nbsp;&nbsp;";
                                            // $comprueba="";
                                            // $valores=[];
                                            foreach ($Asistencias as $key => $value) {
                                                if( $m->id == $value->ID_Miembro){
                                                    if($dia==$value->Fecha ){
                                                        echo "<input type='checkbox' checked='checked'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                        $clave=$key;
                                                        $asis++;
                                                        // $valores[]=$value->Fecha;
                                                    }else{
                                                        
                                                    }
                                                }
                                            }
                                            if($ultimaF<$diaActual){
                                                $noasis++;
                                            }
                                            unset($Asistencias[$clave]);
                                        }
                                    }
                                    
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><?php echo "Total de Asistencias: ".$asis; ?></td>
                            <td colspan="2"><?php echo ' Total de Faltas: '.($noasis-$asis) ?></td>
                        </tr>
                        <?php $contador++;  $asis=0; $noasis=0;?>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div>
        
</body>
</html>
<!-- // for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                    //     $dia =  date("l", $i);
                                    //     if($dia == 'Sunday'){
                                    //         foreach ($Asistencias as $key ) {
                                    //             $diabd = date("Y-m-d", $key->Fecha);
                                    //             if($dia == $diabd ){
                                    //                 if($m->id == $key->ID_Miembro){
                                    //                     ?> -->
                                    <!-- //                     <label for=""><?php //echo $key->Fecha;?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" checked="checked"></label>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                                         <?php
                                    //                 }else{
                                    //                     ?>
                                    <!-- //                     <label for=""><?php //echo $key->Fecha;?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" ></label>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                                         <?php
                                    //                 }
                                    //             }
                                    //         }
                                    //     }
                                    // }
                                    // $si=0; $fechaasistencia="";
                                    // foreach ($Asistencias as $key ) {
                                    //     $diabd =  date("Y-m-d", strtotime($key->Fecha));
                                    //     for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                    //         if( $m->id == $key->ID_Miembro){
                                    //             $dia =  date("l", $i);
                                    //             if($dia == 'Sunday'){
                                    //                 $dia = date("Y-m-d", $i);
                                    //                 if($dia == $diabd){
                                    //                     ?>
                                                          <!-- <label for=""><?php //echo $key->Fecha;?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" checked="checked"></label>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                                          <?php
                                    //                 }else{
                                    //                     ?>
                                                          <!-- <label for=""><?php //echo $key->Fecha;?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" ></label>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                                         <?php
                                    //                 }
                                    //             }
                                    //         }
                                    //     }
                                    // }
                                    
                                            
                                    // foreach ($Asistencias as $key ) {
                                        
                                        
                                    //         for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                    //             $dia =  date("l", $i);
                                    //             if($dia == 'Sunday'){
                                    //                 $dia = date("Y-m-d", $i);
                                    //                 if($dia == $key->Fecha ){
                                    //                     if($m->id == $key->ID_Miembro){
                                    //                         echo "Asistio ".$key->Fecha;
                                    //                     }else{
                                    //                         echo "noAsistio ".$key->Fecha;
                                    //                     }
                                    //                 }
                                    //             }
                                    //         }
                                            
                                        
                                    // }