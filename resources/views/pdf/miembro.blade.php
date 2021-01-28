<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEOP</title>
    <style>
        /* spacing */

        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 3px solid #000000;
        }
        th, td {
            width: 25%;
            text-align: left;
            vertical-align: top;
            border: 1px solid #000;
            border-spacing: 0;
            padding: 8px;
        }
        .page-break {
            page-break-after: always;
        }
        .alinear{
            text-align: right;
        }  
        .imagen{
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
        .contenedor{
            width:100%;
        }
        .cuerpo-img{
            display:inline-block;
            width:30%;
        }
        .encabezado{
            display:inline-block;
            width:60%;
            text-align:center;
        }
        .tabla{
            display:block;
            font-size:x-small;
        }

    </style>
</head>
<body>
        <div class="alinear" >
            <strong>Orizaba, Veracruz a <?php echo $Fecha;?> </strong>
        </div>
        <section>
            <?php //foreach ($datos as $d) {?>
                <!-- <img src="img/<?php //echo $d->Imagen;?>" alt=""> -->
            <?php //}?>
            @foreach($datos as $d)
                <div class="contenedor">
                    <div class="cuerpo-img">
                        @if($d->Imagen=="" || $d->Imagen==null)
                            El miembro no tiene cargada imagen
                        @else
                        <img class="imagen" src="img/{{$d->Imagen}}" alt="miembro" width="150" height="150">      
                        @endif
                    </div>
                    <div class="encabezado ">
                        <h3>Centro Evangélico Orizaba Poniente (CEOP) <br> </h3>
                        <h4>Miembro <?php if($d->Condicion == "1"){echo "Activo";}else{echo "Inactivo";}?></h4>
                    </div>
                </div>
                <div class="tabla"> 
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align:center;" colspan="3">DATOS DEL MIEMBRO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nombre: <br><strong>{{$d->Nombre}}</strong></td>
                                <td>Apellido Paterno: <br> <strong>{{$d->Apellido_P}}</strong> </td>
                                <td>Apellido Materno: <br> <strong>{{$d->Apellido_M}}</strong> </td>
                            </tr>
                            <tr>
                                <td>Genero: <strong><?php if($d->Genero=="1"){echo "Hombre";}else{ echo "Mujer";}?></strong></td>
                                <td>
                                    Estado civil: 
                                    <strong>
                                    <?php 
                                        if($d->EstadoCivil=='1'){
                                            echo "Soltero (a)";
                                        }else if($d->EstadoCivil=='2'){
                                            echo "Casado (a)";
                                        }else if($d->EstadoCivil=='3'){
                                            echo "Divorciado (a)";
                                        }else if($d->EstadoCivil=='4'){
                                            echo "Viudo (a)";
                                        }else{
                                            echo "Unión libre";
                                        }
                                    ?>
                                    </strong>
                                </td>
                                <td>Fecha de Nacimiento: <strong>{{$d->FechaNac}}</strong> </td>
                                
                            </tr>
                            <tr>
                                <td colspan="2">Edad: 
                                    <strong>
                                        @foreach($Edades as $e)
                                            @if($e->id===$d->id)
                                                {{$e->Edad}}
                                            @endif
                                        @endforeach
                                    </strong> 
                                </td>
                                <td colspan="1">Antiguedad
                                    <strong>
                                        @foreach($Antiguedades as $a)
                                            @if($a->id===$d->id)
                                                {{$a->Antiguedad}}
                                            @endif
                                        @endforeach
                                        
                                    </strong> 
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha de Ingreso: <strong>{{$d->FechaIngreso}}</strong></td>
                                <td>Grupo: 
                                    <strong>
                                        @foreach($Grupos as $g)
                                            @if($g->id===$d->Grupo)
                                                {{$g->Nombre}}
                                            @endif
                                        @endforeach
                                    </strong> 
                                </td>
                                <td>Ministerio: 
                                    <strong>
                                        @foreach($Ministerios as $m)
                                            @if($m->id==$d->Ministerio)
                                                {{$m->Nombre}}
                                            @endif
                                        @endforeach
                                    </strong> 
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center; " colspan="3"><strong>DATOS DE CONTACTO</strong></td>
                            </tr>
                            <tr>
                                <td>Correo: <strong>{{$d->Correo}}</strong></td>
                                <td>Teléfono: <strong>{{$d->Telefono}}</strong> </td>
                                <td>Dirección: <br> <strong>{{$d->Direccion}}</strong> </td>
                            </tr>
                            <tr>
                                <td>Ocupación: <strong>{{$d->Ocupacion}}</strong></td>
                                <td>Papá: <br> <strong>{{$d->Padre}}</strong> </td>
                                <td>Mamá: <br> <strong>{{$d->Madre}}</strong> </td>
                            </tr>
                            <tr>
                                <td style="text-align:center; " colspan="3"><strong>DATOS DE IGLESIA</strong></td>
                            </tr>
                            <tr>
                                <td>Fecha de Conversión: <strong>{{$d->FechaConversion}}</strong></td>
                                <td>Bautizado: 
                                    <strong>
                                        @if($d->Bautizado=="1")
                                            Sí
                                        @else
                                            No
                                        @endif
                                    </strong> 
                                </td>
                                <td>Iglesia: <strong>{{$d->Iglesia}}</strong> </td>
                            </tr>
                            @if($d->Condicion=='0')
                                <tr>
                                    <td style="text-align:center; " colspan="3"><strong>DATOS DE INACTIVIDAD</strong></td>
                                </tr>
                                <tr>
                                    <td>Fecha : <strong>{{$d->FechaInactivo}}</strong></td>
                                    <td colspan="2">Motivo: <strong>{{$d->Motivo}}</strong> </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                
                </div>
            @endforeach
        </section>
</body>
</html>