@extends('admin.layouts')

@section('panel-content')
    <h2 class="text-2xl font-bold mb-4">Crear noticia</h2>
    {{--
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
--}}
    <form action="{{ route('noticias.createNoticia') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Título</label>
            <input name="titulo" value="{{ old('titulo') }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mt-3">
            <label>Categoría</label>
            <select name="categoria" class="w-full p-2 border rounded" required>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="w-full p-2 border rounded" rows="6">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mt-3">
            <label>Imagen principal</label>
            <input type="file" name="imagen" accept="image/*" class="w-full" required>
        </div>

        <div class="mt-4">
            <button type ="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">Crear noticia</button>
            <a href="{{ route('admin.noticias') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>
    </form>
@endsection
