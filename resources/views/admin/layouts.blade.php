<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">


</head>

<body class="bg-gray-50">

    {{-- Header --}}
    <header class="bg-emerald-600 text-white py-4 shadow">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div>
                <h1 class="text-2xl font-bold">Panel de Administración</h1>
                <p class="text-sm opacity-90">Cisne Consultorios</p>
            </div>

            <div class="flex items-center gap-3">
                {{--   <a href="{{ url('/') }}" class="text-white bg-emerald-800 px-3 py-2 rounded">Volver al sitio</a> --}}

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-white bg-blue-600 hover:bg-emerald-700 px-3 py-2 rounded">Cerrar
                        sesión</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-6 py-8 flex gap-8">

        {{-- Sidebar --}}
        <aside class="w-72 bg-white rounded-md shadow p-4">
            <nav class="space-y-2">

                {{-- Panel --}}
                <a href="{{ route('admin.panel') }}"
                    class="block px-3 py-2 rounded
                   {{ request()->is('admin/panel') ? 'bg-emerald-100 font-semibold' : 'hover:bg-gray-100' }}">
                    📊 Panel
                </a>

                {{-- Profesionales --}}
                <a href="{{ route('admin.profesionales') }}"
                    class="block px-3 py-2 rounded
                   {{ request()->is('admin/profesionales*') ? 'bg-emerald-100 font-semibold' : 'hover:bg-gray-100' }}">
                    👩‍⚕️ Profesionales
                </a>

                {{-- Noticias --}}
                <a href="{{ route('admin.noticias') }}"
                    class="block px-3 py-2 rounded
                   {{ request()->is('admin/noticias*') ? 'bg-emerald-100 font-semibold' : 'hover:bg-gray-100' }}">
                    📰 Comunicados
                </a>

                {{-- Instituciones --}}

                <a href ="{{ route('admin.instituciones') }}"
                    class="block px-3 py-2 rounded
                   {{ request()->is('admin/instituciones*') ? 'bg-emerald-100 font-semibold' : 'hover:bg-gray-100' }}">
                    🏥 Instituciones
                </a>
            </nav>
        </aside>

        <dialog id="dialog-eliminar" class="p-0 backdrop:bg-black/50 rounded-lg">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto">

        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">
                Confirmar eliminación
            </h3>

            <p class="mt-4 text-sm text-gray-600">
                ¿Está seguro de eliminar este registro?
            </p>
        </div>

        <div class="flex justify-end gap-3 bg-gray-100 px-6 py-4 rounded-b-lg">
            <button type="button"
                onclick="this.closest('dialog').close()"
                class="px-4 py-2 text-sm rounded-md bg-gray-300 hover:bg-gray-400">
                Cancelar
            </button>

            <button type="button"
                id="confirmarEliminar"
                class="px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                Eliminar
            </button>
        </div>
    </div>
</dialog>

<dialog id="dialog-feedback" class="p-0 backdrop:bg-black/50 rounded-lg">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto">

        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">
                Operación realizada
            </h3>

            <p id="feedback-message" class="mt-4 text-sm text-gray-600"></p>
        </div>

        <div class="flex justify-end bg-gray-100 px-6 py-4 rounded-b-lg">
            <button type="button"
                onclick="this.closest('dialog').close()"
                class="px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                Aceptar
            </button>
        </div>
    </div>
</dialog>

        {{-- Contenido dinámico --}}
        <main class="flex-1 bg-white rounded-md shadow p-6">
            @yield('panel-content')
        </main>

    </div>
      <script src="{{ asset('js/scripts.js') }}"></script> 
</body>

</html>
