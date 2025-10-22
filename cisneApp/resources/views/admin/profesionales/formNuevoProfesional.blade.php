@extends('admin.panel')

@section('panel-content')
    <h2 class="text-2xl font-bold mb-4">Crear Profesional</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profesionales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Nombre</label>
                <input name="nombre" value="{{ old('nombre') }}" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm">Especialidad (categoria)</label>
                <input name="categoria" value="{{ old('categoria') }}" class="w-full p-2 border rounded" required>
            </div>


            <div>
                <label class="block text-sm">Matrícula</label>
                <input name="matricula" value="{{ old('matricula') }}" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-sm">Imágenes (rostro) — puedes subir 1</label>
                <input type="file" name="imagenes[]" accept="image/*" class="w-full">
                <small class="text-gray-500"> para rostro subí 1 archivo.</small>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">Crear</button>
            <a href="{{ route('admin.profesionalespanel') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>
    </form>
@endsection
