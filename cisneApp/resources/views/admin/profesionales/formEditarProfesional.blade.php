@extends('admin.panel')

@section('panel-content')
    <h2 class="text-2xl font-bold mb-4">Editar Profesional</h2>

    <form action="{{ route('profesionales.edit', $profesional->id ?? $profesional->id) ?? 'editar' }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        {{-- si tenés update en tu controlador por PUT: --}}
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Nombre</label>
                <input name="nombre" value="{{ old('nombre', $profesional->nombre) }}" class="w-full p-2 border rounded"
                    required>
            </div>

            <div>
                <label>Profesión</label>
                <input name="categoria" value="{{ old('categoria', $profesional->especialidad) }}"
                    class="w-full p-2 border rounded" required>
            </div>

            <div class="col-span-2">
                <label>Descripción</label>
                <textarea name="descripcion" class="w-full p-2 border rounded" rows="4">{{ old('descripcion', $profesional->descripcion) }}</textarea>
            </div>

            <div>
                <label>Matrícula</label>
                <input name="matricula" value="{{ old('matricula', $profesional->matricula) }}"
                    class="w-full p-2 border rounded">
            </div>

            <div>
                <label>Imagen actual</label>
                @if ($imagenes && $imagenes->first())
                    <img src="{{ $imagenes->first()->url }}" class="w-24 h-24 rounded-full object-cover">
                @else
                    <div class="w-24 h-24 bg-gray-200 rounded-full"></div>
                @endif

                <label class="block mt-2 text-sm">Subir nueva imagen (solo rostro)</label>
                {{-- Este POST apunta a route('profesionales.editarImagen') que definimos --}}
                <form action="{{ route('profesionales.editarImagen', $profesional->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="imagen" accept="image/*" required>
                    <button class="mt-2 bg-emerald-600 text-white px-3 py-1 rounded">Actualizar imagen</button>
                </form>
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('admin.profesionalesupdate') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>
    </form>
@endsection
