@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="text-center">
        <h2 class="mb-4">Reportes de Clases y Exámenes</h2>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body bg-[#fff] dark:bg-gray-800">
            <form action="{{ route('reportes.estado_cuenta') }}" method="GET" class="row g-3 align-items-end" target="_blank">
                <div class="col-md-4">
                    <label for="mes" class="form-label text-gray-900 dark:text-gray-300">Selecciona el Mes</label>
                    <input type="month" id="mes" name="mes" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Generar Estado de Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body bg-[#fff] dark:bg-gray-800">
            <form id="filtrosReporte" class="row g-3" method="GET" action="{{ route('reportes.index') }}">
                <div class="col-md-4 text-gray-900 dark:text-gray-300">
                    <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" 
                           value="{{ $fechaInicio }}">
                </div>
                <div class="col-md-4 text-gray-900 dark:text-gray-300">
                    <label for="fechaFin" class="form-label">Fecha Fin</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="form-control" 
                           value="{{ $fechaFin }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-filter me-2"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4 ">
            <div class="card shadow h-100 ">
                <div class="card-header encabezado-custom bg-[#fff] dark:bg-gray-800">
                    <h5 class="mb-0 text-gray-900 dark:text-[#fff]"><i class="fas fa-calendar-alt me-2"></i>Clases por Día</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:40vh;">
                        <canvas id="graficoClases"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header encabezado-custom bg-[#fff] dark:bg-gray-800">
                    <h5 class="mb-0 text-gray-900 dark:text-[#fff]"><i class="fas fa-chart-pie me-2"></i>Resultados de Exámenes</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:40vh;">
                        <canvas id="graficoExamenes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header encabezado-custom bg-[#fff] dark:bg-gray-800">
            <h5 class="mb-0 text-gray-900 dark:text-[#fff]"><i class="fas fa-user-tie me-2"></i>Instructores con más clases</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="encabezado-oscuro">Instructor</th>
                            <th class="encabezado-oscuro">Clases Impartidas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instructores as $instructor)
                        <tr>
                            <td>{{ $instructor->rfc_emp }}</td> 
                            <td>{{ $instructor->total }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">No hay datos en este rango de fechas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clasesPorDia = @json($clasesPorDia);
        const resultadosExamenes = @json($resultadosExamenes);

        const ctxClases = document.getElementById('graficoClases');
        if (ctxClases) {
            new Chart(ctxClases, {
                type: 'bar',
                data: {
                    labels: clasesPorDia.map(item => item.fecha),
                    datasets: [{
                        label: 'Clases por Día',
                        data: clasesPorDia.map(item => item.total),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }

        const ctxExamenes = document.getElementById('graficoExamenes');
        if (ctxExamenes) {
            new Chart(ctxExamenes, {
                type: 'pie',
                data: {
                    labels: ['Aprobados Teórico', 'Reprobados Teórico', 'Aprobados Práctico', 'Reprobados Práctico'],
                    datasets: [{
                        data: [
                            resultadosExamenes ? resultadosExamenes.aprobados_teo : 0,
                            resultadosExamenes ? resultadosExamenes.reprobados_teo : 0,
                            resultadosExamenes ? resultadosExamenes.aprobados_prac : 0,
                            resultadosExamenes ? resultadosExamenes.reprobados_prac : 0
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)', 'rgba(255, 99, 132, 0.7)',
                            'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    });
</script>
@endsection