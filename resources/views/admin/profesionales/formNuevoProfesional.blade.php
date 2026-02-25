@extends('admin.layouts')

@section('title', 'Crear Profesional')

@section('panel-content')

    <h2 class="text-2xl font-bold mb-4">Crear Profesional</h2>
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
    <form class="form" action="{{ route('admin.profesionales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block text-sm">Nombre</label>
                <input name="nombre" class="w-full p-2 border rounded" id="nombre" required>
            </div>

            <div>
                <label class="block text-sm">Especialidad</label>
                <input name="especialidad" class="w-full p-2 border rounded" id="especialidad " required>
            </div>

            <!-- <div class="col-span-2">
                                                                                                <label class="block text-sm">Descripción</label>
                                                                                                <textarea name="descripcion" class="w-full p-2 border rounded" rows="4"></textarea>
                                                                                            </div>
                                                                                        -->
            <div>
                <label class="block text-sm">Matrícula</label>
                <input name="matricula" class="w-full p-2 border rounded" id="matricula">

            </div>

            <div>
                <label class="block text-sm">Imagen (rostro)</label>
                <input type="file" name="imagen" accept="image/*" class="w-full" id="imagen"required>


            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded crear">Crear</button>
            <a href="{{ route('admin.profesionales') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>

    </form>

@endsection
