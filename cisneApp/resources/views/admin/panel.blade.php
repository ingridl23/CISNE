{{-- resources/views/admin/panel.blade.php --}}
@extends('templateHome') {{-- o el layout principal que uses --}}

@section('title', 'Panel - Cisne')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <header class="bg-emerald-700 text-white py-4 shadow">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div>
                    <h1 class="text-2xl font-bold">Panel de Administración</h1>
                    <p class="text-sm opacity-90">Cisne Consultorios</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="text-white bg-emerald-800 px-3 py-2 rounded">Volver al sitio</a>
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
                    <a href="{{ route('admin.profesionales') }}"
                        class="block px-3 py-2 rounded {{ request()->is('admin/profesionales*') ? 'bg-emerald-100 font-semibold' : 'hover:bg-gray-100' }}">👩‍⚕️
                        Profesionales</a>
                    <a href="{{ route('admin.noticias') }}"
                        class="block px-3 py-2 rounded {{ request()->is('admin/noticias*') ? 'bg-emerald-100 font-semibold' : 'hover:bg-gray-100' }}">📰
                        Noticias</a>
                    <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">🏥 Instituciones</a>
                </nav>
            </aside>

            {{-- Content area --}}
            <main class="flex-1 bg-white rounded-md shadow p-6">
                @yield('panel-content')
            </main>
        </div>
    </div>
@endsection
