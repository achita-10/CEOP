<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>prueba pdf</h1>
    <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Comprobante</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($datos as $d)
                        <tr>
                            <td>{{$d->id}}</td>
                            <td>{{$d->Nombre}}</td>
                            <td>{{$d->Comprobante}}</td>
                            <td>{{$d->Fecha}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
</body>
</html>