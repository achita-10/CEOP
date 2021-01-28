<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $Tipo; if ($Accion==1){  echo '_('.$Inicio.')-('.$Fin.')';} else if($Accion==2){ echo '_'.$Fecha;}else{}?></title>
    <style>
        /* spacing */

        table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
        border: 3px solid #000000;
        }
        th, td {
        padding: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;"> <?php  if($Tipo=='NoBautizados'){echo 'Miembros No Bautizados';}else if($Tipo=='Bautizados'){echo "Miembros ".$Tipo;}else if($Tipo=='Cumpleaños'){ echo "Cumpleaños de miembros";}else{ echo "Miembros fallecidos";}?></h1>
    <h4> <?php if ($Accion==1){  echo 'Rango de fecha: ('.$Inicio.')-('.$Fin.')';} else if($Accion==2){ echo 'Fecha: '.$Fecha;}else{} echo "  Total de miembros: ".$Total;?></h4>
    <section>
        <div>
            <table id="facarticulo">
                <thead>
                    <tr id="fa">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Estado civil</th>
                        <th>Fecha de nacimiento</th>
                        <th>Fecha de Ingreso</th>
                        <?php if ($Tipo!='Cumpleaños'){?>
                            <?php if($Tipo=='Bautizados' ){?>
                                <th>Fecha de bautizo</th>
                            <?php } else if($Tipo=='Fallecidos'){ ?>
                                <th>Fecha de deceso</th>
                            <?php }else{  ?>
                            <th>Telefono</th>
                            <?php }?>
                            <th>Iglesia</th>
                            <th>Grupo</th>
                            <th>Ministerio</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                <?php $contador=1; $bucle=1?>
                @foreach($datos as $d)
                    <?php if($bucle<50){?>
                    <tr style="text-align:center;">
                        <td><?php echo $contador?></td>
                        <td>{{$d->Nombre}}</td>
                        <td>{{$d->Apellido_P}} {{$d->Apellido_M}}</td>
                        
                        <td>
                                @if($d->EstadoCivil=='1')
                                    Soltero(a)
                                @elseif($d->EstadoCivil=='2')
                                    Casado(a)
                                @elseif($d->EstadoCivil=='3')
                                    Divorciado(a)
                                @elseif($d->EstadoCivil=='4')
                                    Viudo(a)
                                @else
                                    Union libre
                                @endif
                        </td>
                        <td>{{$d->FechaNac}}</td>
                        <td>{{$d->FechaIngreso}}</td>
                            <?php if ($Tipo!='Cumpleaños'){?>
                            <?php if($Tipo=='Bautizados' ){?>
                                <td>{{$d->FechaBautizo}}</td>
                            <?php } else if($Tipo=='Fallecidos'){ ?>
                                <td>{{$d->FechaDeceso}}</td>
                            <?php }else{  ?>
                            <td>{{$d->Telefono}}</td>
                            <?php }?>
                            <td>{{$d->Iglesia}}</td>
                            <td>
                            @foreach($Grupos as $g)
                                @if($g->id===$d->Grupo)
                                    {{$g->Nombre}}
                                @endif
                            @endforeach
                            </td>
                            <td>
                                @foreach($Ministerios as $m)
                                    @if($m->id==$d->Ministerio)
                                        {{$m->Nombre}}
                                    @endif
                                @endforeach
                            </td>
                        <?php }?>
                    </tr>
                    <?php $contador++;?>
                        <?php } $bucle++;?>

                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <!-- <div class="page-break"></div>
    <h1 style="text-align:center;">Miembros <?php echo $Tipo?></h1> -->
</body>
</html>