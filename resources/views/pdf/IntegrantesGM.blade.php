<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ministerios</title>
    <style>
        /* spacing */

        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 3px solid #000000;
            font-size: x-small;
            text-align:center;
        }
        
        th, td {
            width: 25%;
            vertical-align: top;
            border: 1px solid #000;
            border-spacing: 0;
            padding: 7px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<h1 style="text-align:center;">Miembros en el <?php if($Tipo=="1"){echo "Ministerio";}else{echo "Grupo";}?></h1>
<h4>Fecha: <?php echo $Fecha.', Total de miembros: '.$Total; ?></h4>
@foreach($Ministerio as $m)
        <div>
            <table>
                <thead>
                    <tr >
                        <td>
                            @if($Tipo=="1")
                            Ministerio: 
                            @else
                            Grupo:
                            @endif
                            <strong>
                                {{$m->NombreS}}
                            </strong>          
                        </td>
                        <td>
                            Encargado: 
                            <strong>
                            
                                {{$m->Encargado}} {{$m->Apellido_P}} {{$m->Apellido_M}}
                            
                            </strong>
                        </td>
                    </tr>
                    
                </thead>
            </table>
        </div>
        <br>
    @endforeach
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
            </tr>
        </thead>
        <?php $contador=1;?>
        
        <tbody>
            @foreach($datos as $d)
            <tr>
                <td><?php echo $contador;?></td>
                <td>{{$d->Nombre}}</td>
                <td>{{$d->Apellido_P}}</td>
                <td>{{$d->Apellido_M}}</td>
            
            </tr>
                <?php $contador++;?>
            @endforeach
        </tbody>
        
        
    </table>
</body>
</html>