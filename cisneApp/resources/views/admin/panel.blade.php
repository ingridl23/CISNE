@extends('admin.layouts')

@section('title', 'Panel')

@section('panel-content')

    <div class="style="height:400px;">
        <canvas id="dashboardChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        fetch("{{ route('admin.panel.estadisticas') }}")
            .then(res => res.json())
            .then(data => {
                new Chart(document.getElementById('dashboardChart'), {
                    type: 'pie',
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    },
                    data: {
                        labels: [
                            'Visitas último mes',
                            'Contactos último mes',
                            'Profesionales',
                            'Noticias',
                            'Hogares'
                        ],
                        datasets: [{
                            data: [
                                data.visitasUltimoMes,
                                data.contactosUltimoMes,
                                data.profesionales,
                                data.noticias,
                                data.hogares
                            ]
                        }]
                    }
                });
            });
    </script>

@endsection
