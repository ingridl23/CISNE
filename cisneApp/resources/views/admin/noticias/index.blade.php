@extends('admin.layouts')

@section('title', 'Noticias')

@section('panel-content')

    {{-- Header - título + botón --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-700">Comunicados</h2>

        {{-- ✅ Mensaje de éxito --}}
        @if (session('success'))
            <div class="alert alert-success text-center mb-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center mb-3">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('admin.noticias.create') }}"
            class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded shadow transition">
            ➕ Nuevo Comunicado
        </a>
    </div>

    {{-- Tabla contenedora --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">

        {{-- Si no hay profesionales --}}
        @if ($noticias->isEmpty())
            <p class="p-6 text-center text-gray-500">
                No hay Noticias cargadas todavía.
            </p>
        @else
            <table class="w-full border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-left font-semibold border-b">Imagen</th>
                        <th class="p-3 text-left font-semibold border-b">Titulo</th>
                        <th class="p-3 text-center font-semibold border-b">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($noticias as $p)
                        <tr class="hover:bg-gray-50 transition border-b">

                            {{-- Imagen --}}
                            <td class="p-3">
                                @if ($p->imagenesNoticias)
                                    <img src="{{ $p->imagenesNoticias->url }}"
                                        class="w-14 h-14 rounded-full object-cover shadow">
                                @else
                                    <div class="w-14 h-14 bg-gray-200 rounded-full"></div>
                                @endif

                            </td>

                            {{-- titulo --}}
                            <td class="p-3 text-gray-800">
                                {{ $p->titulo }}
                            </td>



                            {{-- Acciones --}}
                            <td class="p-3">
                                <div class="flex justify-center gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('admin.noticias.edit', $p->id) }}"
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded shadow transition">
                                        ✏️ Editar
                                    </a>

                                    {{-- Eliminar --}}
                                    <form action="{{ route('admin.noticias.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar Comunicado de la web ?')">
                                        @csrf @method('DELETE')
                                        <button
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm rounded shadow transition">
                                            🗑 Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        @endif
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $noticias->links('pagination::tailwind') }}
    </div>

@endsection
