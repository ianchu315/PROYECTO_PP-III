<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mesas Finales - {{ $carrera->descripcion }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Mesas Finales - {{ $carrera->descripcion }}</h1>

@php
    $mesasPorComision = $mesas->groupBy('comision');
@endphp

@foreach($mesasPorComision as $comision => $mesasComision)
    <h2 style="margin-top:30px;">Comisión {{ $comision }}</h2>

    <table>
        <thead>
            <tr>
                <th>Año</th>
                <th>Materia</th>
                <th>Profesor</th>
                <th>Vocal</th>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Salón</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mesasComision as $mesa)
                <tr>
                    <td>{{ $mesa->anio_id ?? '---' }}</td>
                    <td>{{ $mesa->materia->descripcion ?? '---' }}</td>
                    <td>{{ $mesa->profesor->nombre ?? '---' }} {{ $mesa->profesor->apellido ?? '---' }}</td>
                    <td>{{ $mesa->vocal->nombre ?? '---' }} {{ $mesa->vocal->apellido ?? '---' }}</td>
                    <td>{{ \Carbon\Carbon::parse($mesa->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $mesa->horario }}</td>
                    <td>{{ $mesa->Salon->numero_salon ?? "Sin salón" }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

</body>
</html>
