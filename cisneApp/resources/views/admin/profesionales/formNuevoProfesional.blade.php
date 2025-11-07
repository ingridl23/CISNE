@extends('admin.layouts')

@section('title', 'Crear Profesional')

@section('panel-content')

    <h2 class="text-2xl font-bold mb-4">Crear Profesional</h2>

    <form action="{{ route('admin.profesionales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block text-sm">Nombre</label>
                <input name="nombre" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm">Especialidad</label>
                <input name="especialidad" class="w-full p-2 border rounded" required>
            </div>

            <!-- <div class="col-span-2">
                                <label class="block text-sm">Descripción</label>
                                <textarea name="descripcion" class="w-full p-2 border rounded" rows="4"></textarea>
                            </div>
                        -->
            <div>
                <label class="block text-sm">Matrícula</label>
                <input name="matricula" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-sm">Imagen (rostro)</label>
                <input type="file" name="imagen" accept="image/*" class="w-full" required>


            </div>

        </div>

        <div class="mt-4">
            <button class="bg-emerald-600 text-white px-4 py-2 rounded">Crear</button>
            <a href="{{ route('admin.profesionales') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>

    </form>

@endsection
