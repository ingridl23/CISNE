@extends('admin.layouts')

@section('panel-content')
    <h2 class="text-2xl font-bold mb-4">Editar noticia</h2>
 


    <form class="form" action="{{ route('admin.noticias.update', $noticia->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Título</label>
            <input name="titulo" value="{{ old('titulo', $noticia->titulo) }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mt-3">
            <label>Categoría</label>
           <select name="categoria" class="w-full p-2 border rounded" required>
    @foreach ($categorias as $cat)
        <option value="{{ $cat->id }}" {{ old('categoria') == $cat->id ? 'selected' : '' }}>
            {{ $cat->nombre }}
        </option>
    @endforeach
</select>
        </div>

        <div class="mt-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="w-full p-2 border rounded" rows="6">{{ old('descripcion', $noticia->descripcion) }}</textarea>
        </div>

        <div class="mt-3">
            <label>Imagen actual</label>
            @if ($noticia->imagenesNoticias && $noticia->imagenesNoticias->url)
                <img src="{{ $noticia->imagenesNoticias->url }}" class="w-40 h-28 object-cover rounded">
            @else
                <div class="w-40 h-28 bg-gray-200 rounded"></div>
            @endif

            <p class="mt-2 text-sm text-gray-600">Si subís una nueva imagen, reemplazará la actual.</p>
            <input type="file" name="imagen" accept="image/*" class="mt-2">
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">Guardar cambios</button>
            <a href="{{ route('admin.noticias') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>
    </form>
@endsection
