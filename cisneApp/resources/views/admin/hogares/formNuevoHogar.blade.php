@extends('admin.layouts')

@section('title', 'Crear Profesional')

@section('panel-content')

    <h2 class="text-2xl font-bold mb-4">Crear Institucion</h2>
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
    <form class="form" action="{{ route('admin.instituciones.storeInstitucion') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block text-sm">Nombre</label>
                <input name="nombre" class="w-full p-2 border rounded" id="nombre" required>
            </div>

            <div>
                <label class="block text-sm">Descripcion</label>
                <input name="descripcion" class="w-full p-2 border rounded" id="especialidad " required>
            </div>



            <div>
                <label class="block text-sm">Imagen (Portada)</label>
                <input type="file" name="imagen" accept="image/*" class="w-full" id="imagen"required>


            </div>





        </div>

        <div class="mt-4">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded crear">Publicar</button>
            <a href="{{ route('admin.instituciones') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>

    </form>

@endsection
