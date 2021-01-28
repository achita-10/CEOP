<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miembros<?php if($Tipo=='4'){echo "activos";}else{echo "inactivos";} if ($Accion==1){  echo '_('.$Inicio.')-('.$Fin.')';} else if($Accion==2){ echo '_'.$Fecha;}else{}?>  de CEOP</title>
    <style>
        /* spacing */

        table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
        border: 3px solid #000000;
        }
        td,th{
            padding: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<h1 style="text-align:center;">Miembros <?php if($Tipo=='4'){echo "activos";}else{echo "inactivos";}?></h1>
<h4> <?php if ($Accion==1){  echo 'Rango de fecha: ('.$Inicio.')-('.$Fin.')';} else if($Accion==2 || $Accion==3){ echo 'Fecha: '.$Fecha;}else{} echo "  Total de miembros: ".$Total;?></h4>
    <section>
        <div>
            <table id="facarticulo">
                <thead>
                    <tr id="fa">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido Materno</th>
                        <th>Apellido Materno</th>
                        <?php if ($Tipo =="4"){?>
                        <th>Grupo</th>
                        <th>Ministerio</th>
                        <!-- <th>Antiguedad</th> -->
                        <?php }?>
                        <?php if($Tipo=="5") { ?>
                        <th>Motivo</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                <?php $contador=1; ?>
                @foreach($datos as $d)
                    <tr style="text-align:center;">
                        <td><?php echo $contador;?></td>
                        <td>{{$d->Nombre}}</td>
                        <td>{{$d->Apellido_P}} </td>
                        <td>{{$d->Apellido_M}}</td>
                        <?php if ($Tipo =="4"){?>
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
                        
                        <?php } else {?>
                            <td>
                                {{$d->Motivo}}
                            </td>
                        <?php }?>
                    </tr>
                    <?php $contador++;?>
                       

                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>