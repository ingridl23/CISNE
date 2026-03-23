@extends('admin.layouts')

@section('title', 'Editar Profesional')

@section('panel-content')

    <h2 class="text-2xl font-bold mb-4">Editar Profesional</h2>
    {{--  Mensaje de éxito --}}
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
<form class ="form" action="{{ route('admin.profesionales.update', $profesional->id) }}" method="POST"  enctype="multipart/form-data">
    @csrf
    @method('PUT')


        <div class="grid grid-cols-2 gap-4">

            <div>
                <label>Nombre</label>
                <input name="nombre" value="{{ $profesional->nombre }}" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label>Especialidad</label>
                <input name="especialidad" value="{{ $profesional->especialidad }}" class="w-full p-2 border rounded"
                    required>
            </div>
            <!--
                            <div class="col-span-2">
                                <label>Descripción</label>
                                <textarea name="descripcion" class="w-full p-2 border rounded" rows="4">{{ $profesional->descripcion }}</textarea>
                            </div>
                        -->
            <div>
                <label>Matrícula</label>
                <input name="matricula" value="{{ $profesional->matricula }}" class="w-full p-2 border rounded">
            </div>

            <div>
              <label>Imagen actual</label>
              @if ($imagen && $imagen->url)
                <img src="{{ $imagen->url }}" class="w-40 h-28 object-cover rounded">
            @else
                <div class="w-40 h-28 bg-gray-200 rounded"></div>
            @endif
             <p class="mt-2 text-sm text-gray-600">Si subís una nueva imagen, reemplazará la actual.</p>
                <label class="block text-sm mt-2">Subir nueva imagen</label>
                <input type="file" name="imagen" accept="image/*">
            </div>


        </div>

        <div class="mt-4">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('admin.profesionales') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>

    </form>

@endsection
