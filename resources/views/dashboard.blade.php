<!-- // Muestra el dashboard del administrador con estadísticas resumidas, enlaces a ofertas y usuarios, y gráficos interactivos de ofertas, aplicaciones, alumnos por carrera y género.

 -->

@extends('layouts.dashboard_layout')

@section('content')

<section class="dashboard_section">

    <div class="dashboard_titulo">
        <h1>Dashboard</h1>
    </div>

    <div class="dashboard_stats">
        <a href="{{ route('bolsadetrabajo.ofertas') }}">
            <div class="dashboard_stats_item">
                <div class="dashboard_stats_item_titulo_logo">
                    <h2>Ofertas totales</h2>
                    <i class="ri-briefcase-4-line"></i>
                </div>
                <h3>{{ $ofertas->count() }}</h3>
                <p>Total de ofertas disponibles en la plataforma</p>
            </div>
        </a>

        <a href="{{ route('bolsadetrabajo.ofertas') }}">
            <div class="dashboard_stats_item">
                <div class="dashboard_stats_item_titulo_logo">
                    <h2>Aplicaciones totales</h2>
                    <i class="ri-bar-chart-line"></i>
                </div>
                <h3>{{ $todasPostulaciones }}</h3>
                <p>Total de aplicaciones realizadas en la plataforma</p>
            </div>
        </a>

        <a href="{{ route('bolsadetrabajo.usuarios') }}">
            <div class="dashboard_stats_item">
                <div class="dashboard_stats_item_titulo_logo">
                    <h2>Usuarios registrados</h2>
                    <i class="ri-group-line"></i>
                </div>
                <h3>{{ $usuarios }}</h3>
                <p>Total de usuarios registrados en la plataforma</p>
            </div>
        </a>

        <a href="{{ route('bolsadetrabajo.ofertas') }}">
            <div class="dashboard_stats_item">
                <div class="dashboard_stats_item_titulo_logo">
                    <h2>Aplicaciones por semana</h2>
                    <i class="ri-user-shared-line"></i>
                </div>
                <h3>{{ $ultimasPostulaciones->count() }}</h3>
                <p>Total de aplicaciones realizadas en la última semana</p>
            </div>
        </a>

    </div>

    <div class="dashboard_graficos">
        <div class="dashboard_graficos_item">
            <h2>Ofertas por semana</h2>
            <div class="chart-container">
                <canvas id="graficoOfertas" class="grafico-barras"></canvas>
            </div>
        </div>

        <div class="dashboard_graficos_item">
            <h2>Alumnos por carrera</h2>
            <div class="chart-container">
                <canvas id="graficoCarreras"></canvas>
            </div>
        </div>

        <div class="dashboard_graficos_item">
            <h2>Alumnos por género</h2>
            <div class="chart-container">
                <canvas id="graficoGeneros"></canvas>
            </div>
        </div>

        <div class="dashboard_graficos_item">
            <h2>Aplicaciones por semana</h2>
            <div class="chart-container">
                <canvas id="graficoPostulaciones"></canvas>
            </div>
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfico de ofertas por semana
            const ctxOfertas = document.getElementById('graficoOfertas');
            new Chart(ctxOfertas, {
                type: 'bar',
                data: {
                    labels: @json($ofertasLabels),
                    datasets: [{
                        label: 'Ofertas publicadas',
                        data: @json($ofertasData),
                        backgroundColor: '#700101',
                        borderColor: '#700101',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    onClick: function(evt, elements) {
                        if (elements.length > 0) {
                            let index = elements[0].index;
                            let fecha = @json($ofertasFechas)[index];
                            window.location.href = "{{ route('bolsadetrabajo.ofertas') }}" + "?fecha=" + fecha;

                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 3,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Gráfico de alumnos por carrera
            const ctxCarreras = document.getElementById('graficoCarreras');
            const idsCarreras = @json($idsCarreras); // ✅ IDs de las carreras

            new Chart(ctxCarreras, {
                type: 'pie',
                data: {
                    labels: @json($labelsCarreras),
                    datasets: [{
                        label: 'Alumnos por carrera',
                        data: @json($cantidadesCarreras),
                        backgroundColor: [
                            '#700101', '#A52727', '#D9534F', '#F28B82', '#4E342E', '#BCAAA4', '#455A64', '#263238'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2.2,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 20,
                                padding: 15
                            }
                        }
                    },
                    onClick: function(evt, activeEls) {
                        if (activeEls.length > 0) {
                            const index = activeEls[0].index;
                            const carreraId = idsCarreras[index]; // ✅ ID de la carrera
                            window.location.href = "{{ route('bolsadetrabajo.usuarios') }}" + "?carrera_id=" + carreraId;
                        }
                    }
                }
            });
        });



        const ctxGeneros = document.getElementById('graficoGeneros');
        const idsGeneros = @json($idsGeneros); // ['masculino','femenino','otro']

        new Chart(ctxGeneros, {
            type: 'doughnut',
            data: {
                labels: @json($labelsGeneros),
                datasets: [{
                    label: 'Alumnos por género',
                    data: @json($cantidadesGeneros),
                    backgroundColor: ['#1E88E5', '#E91E63', '#9E9E9E', '#FFC107', '#4CAF50', '#FF5722'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 20,
                            padding: 15
                        }
                    }
                },
                onClick: function(evt, activeEls) {
                    if (activeEls.length > 0) {
                        const index = activeEls[0].index;
                        const genero = idsGeneros[index]; // 'femenino', 'masculino', etc.
                        window.location.href = "{{ route('bolsadetrabajo.usuarios') }}" + "?genero=" + genero;
                    }
                }
            }
        });




        // Gráfico de postulaciones por semana
        const ctxPostulaciones = document.getElementById('graficoPostulaciones');
        new Chart(ctxPostulaciones, {
            type: 'line',
            data: {
                labels: @json($postulacionesLabels),
                datasets: [{
                    label: 'Aplicaciones realizadas',
                    data: @json($postulacionesData),
                    fill: false,
                    borderColor: '#1E88E5',
                    backgroundColor: '#1E88E5',
                    tension: 0.3,
                    pointBackgroundColor: '#1E88E5',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>


</section>

@endsection