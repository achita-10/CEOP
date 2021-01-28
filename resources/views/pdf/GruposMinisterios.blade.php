<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if ($Accion==1){  echo 'Grupos_'.$Fecha;} else if($Accion==2){ echo 'Ministerios_'.$Fecha;}?></title>
    <style>
        /* spacing */

        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 3px solid #000000;
        }
        th, td {
            padding: 6px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;"><?php if ($Accion==1){  echo 'Grupos';} else if($Accion==2){ echo 'Ministerios';}?> de CEOP</h1>
    <h4>Fecha: <?php echo $Fecha.','; ?> Total de <?php if ($Accion==1){  echo 'Grupos ';} else if($Accion==2){ echo 'Ministerios ';} echo $Total;?></h4>
    <section>
        <div>
            <table id="facarticulo">
                <thead>
                    <tr id="fa">
                        <th>#</th>
                        <th><?php if ($Accion==1){  echo 'Grupos';} else if($Accion==2){ echo 'Ministerios';}?></th>
                        <th>Encargado</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                    </tr>
                </thead>
                <tbody>
                <?php $contador=1; ?>
                @foreach($datos as $d)
                    <tr style="text-align:center;">
                        <td><?php echo $contador;?></td>
                        <td>{{$d->NombreS}}</td>
                        <td>{{$d->Encargado}}  </td>
                        <td>{{$d->Apellido_P}}</td>
                        <td>{{$d->Apellido_M}}</td>
                    </tr>
                    <?php $contador++;?>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
    
</body>
</html>