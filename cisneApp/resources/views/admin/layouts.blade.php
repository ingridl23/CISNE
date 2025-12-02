<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">


</head>

<body class="bg-gray-50">

    {{-- Header --}}
    <header class="bg-emerald-700 text-white py-4 shadow">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div>
                <h1 class="text-2xl font-bold">Panel de Administración</h1>
                <p class="text-sm opacity-90">Cisne Consultorios</p>
            </div>

            <div class="flex items-center gap-3">
                {{--   <a href="{{ url('/') }}" class="text-white bg-emerald-800 px-3 py-2 rounded">Volver al sitio</a> --}}

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-white bg-red-600 px-3 py-2 rounded">Cerrar sesión</button>
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

        {{-- Contenido dinámico --}}
        <main class="flex-1 bg-white rounded-md shadow p-6">
            @yield('panel-content')
        </main>

    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
