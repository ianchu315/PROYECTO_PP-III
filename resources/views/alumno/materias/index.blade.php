@extends('layouts.panel')

@section('titulo', 'Mis materias')

@section('content')
<div class="pf-page-header">
    <h1>Mis materias</h1>
</div>

@if($materias->isEmpty())
    <div class="pf-card">
        <p class="pf-muted mb-0">Todavía no estás inscripto en ninguna materia.</p>
    </div>
@else
    @foreach($materias as $item)
        <div class="pf-card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">
                <div>
                    <h3 style="margin-bottom:2px;">{{ $item['materia']->descripcion }}</h3>
                    <span class="pf-muted" style="font-size:13px;">{{ $item['materia']->deCarrera->descripcion ?? '-' }}</span>
                </div>
                <span class="pf-badge pf-badge-{{ $item['condicion'] }}">
                    {{ ucfirst($item['condicion']) }}
                </span>
            </div>

            @if($item['notas']->isEmpty() && !$item['notaExtra'])
                <p class="pf-muted" style="margin-top:14px; margin-bottom:0;">Todavía no tenés notas cargadas en esta materia.</p>
            @else
                <div class="pf-table-wrap" style="margin-top:14px;">
                    <table class="pf-table">
                        <thead>
                            <tr>
                                <th>Cuatrimestre</th>
                                <th>N°</th>
                                <th>Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item['notas'] as $nota)
                                <tr>
                                    <td>{{ $nota->cuatrimestre }}°</td>
                                    <td>{{ $nota->numero_nota }}</td>
                                    <td>{{ $nota->nota ?? '-' }}</td>
                                </tr>
                            @endforeach
                            @if($item['notaExtra'])
                                <tr>
                                    <td colspan="2"><strong>Nota final / recuperatorio</strong></td>
                                    <td>{{ $item['notaExtra']->nota ?? '-' }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endforeach
@endif
@endsection
