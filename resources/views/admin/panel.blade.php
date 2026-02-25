@extends('admin.layouts')

@section('title', 'Panel')

@section('panel-content')


    <h2 class="text-2xl font-bold text-gray-700">Resumen general</h2>
    <br>
    {{-- CARDS --}}
    <div id="statsCards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-emerald-50 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Visitas último mes</p>
            <p id="cardVisitas" class="text-3xl font-bold">0</p>
        </div>

        <div class="bg-blue-50 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Contactos último mes</p>
            <p id="cardContactos" class="text-3xl font-bold">0</p>
        </div>

        <div class="bg-purple-50 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Profesionales</p>
            <p id="cardProfesionales" class="text-3xl font-bold">0</p>
        </div>

        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Noticias</p>
            <p id="cardNoticias" class="text-3xl font-bold">0</p>
        </div>

        <div class="bg-pink-50 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Hogares</p>
            <p id="cardHogares" class="text-3xl font-bold">0</p>
        </div>
    </div>
    <br>
    <br>
    <br>

    {{-- GRAFICO TORTA --}}
    <div class="style="height:400px;">
        <canvas id="dashboardChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        fetch("{{ route('admin.panel.estadisticas') }}")
            .then(res => res.json())
            .then(data => {


                // CARDS
                document.getElementById('cardVisitas').textContent = data.visitasUltimoMes;
                document.getElementById('cardContactos').textContent = data.contactosUltimoMes;
                document.getElementById('cardProfesionales').textContent = data.profesionales;
                document.getElementById('cardNoticias').textContent = data.noticias;
                document.getElementById('cardHogares').textContent = data.hogares;




                //GRAFICO
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



    {{-- formulario de descarga de pacientes hogares o profesionales que se contactaron --}}
    {{-- DESCARGA DE CONTACTOS --}}
    <div class="mt-10 bg-gray-50 border rounded p-6">
        <h3 class="text-lg font-semibold mb-4">Descargar contactos</h3>

        <form method="GET" action="{{ route('admin.panel.descargas') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- Tipo --}}
            <div>
                <label class="text-sm font-medium">Tipo</label>
                <select name="tipo" class="w-full border rounded px-2 py-1" required>
                    <option value="">Seleccionar</option>
                    <option value="pacientes">Pacientes</option>
                    <option value="profesionales">Profesionales</option>
                    <option value="hogares">Hogares</option>
                </select>
            </div>

            {{-- Desde --}}
            <div>
                <label class="text-sm font-medium">Desde</label>
                <input type="date" name="desde" class="w-full border rounded px-2 py-1">
            </div>

            {{-- Hasta --}}
            <div>
                <label class="text-sm font-medium">Hasta</label>
                <input type="date" name="hasta" class="w-full border rounded px-2 py-1">
            </div>

            {{-- Botón --}}
            <div class="flex items-end">
                <button class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                    Descargar CSV
                </button>
            </div>

        </form>
    </div>

@endsection
