@extends('admin.panel')

@section('title', 'Editar Profesional')

@section('panel-content')

    <h2 class="text-2xl font-bold mb-4">Editar Profesional</h2>

    <form action="{{ route('profesionales.update', $profesional->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label>Nombre</label>
                <input name="nombre" value="{{ $profesional->nombre }}" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label>Especialidad</label>
                <input name="categoria" value="{{ $profesional->especialidad }}" class="w-full p-2 border rounded" required>
            </div>

            <div class="col-span-2">
                <label>Descripción</label>
                <textarea name="descripcion" class="w-full p-2 border rounded" rows="4">{{ $profesional->descripcion }}</textarea>
            </div>

            <div>
                <label>Matrícula</label>
                <input name="matricula" value="{{ $profesional->matricula }}" class="w-full p-2 border rounded">
            </div>

            <div>
                <label>Imagen actual</label><br>

                @if ($imagenes && $imagenes->first())
                    <img src="{{ $imagenes->first()->url }}" class="w-24 h-24 rounded-full object-cover mb-2">
                @endif

                <label class="block text-sm mt-2">Subir nueva imagen</label>
                <input type="file" name="imagen" accept="image/*">
            </div>

        </div>

        <div class="mt-4">
            <button class="bg-emerald-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('profesionales.index') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>

    </form>

@endsection
