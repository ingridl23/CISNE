@extends('admin.layouts')

@section('title', 'Editar Profesional')

@section('panel-content')

    <h2 class="text-2xl font-bold mb-4">Editar Institucion</h2>
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
    <form action="{{ route('admin.instituciones.update', $hogar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid gap-4">

            {{-- Imagen --}}
            <div>
                <label class="block text-sm">Imagen (Portada)</label>
                @if ($hogar->imagenes && $hogar->imagenes->first()->url)
                    <img src="{{ $hogar->imagenes->first()->url }}" class="w-40 h-28 object-cover rounded" id="imagen">
                @else
                    <div class="w-40 h-28 bg-gray-200 rounded"></div>
                @endif
                <input type="file" name="imagen" accept="image/*" class="w-full" id="imagen">
            </div>

            {{-- Nombre --}}
            <div>
                <label class="block text-sm">Nombre</label>
                <input name="nombre" class="w-full p-2 border rounded" value="{{ old('nombre', $hogar->nombre) }}"
                    required>
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm">Descripcion</label>
                <input name="descripcion" class="w-full p-2 border rounded"
                    value="{{ old('descripcion', $hogar->descripcion) }}" required>
            </div>

            {{-- Facebook --}}
            <div>
                <label class="block text-sm" for="facebook">Facebook</label>
                <input type="text" name="facebook" id="facebook" value="{{ old('facebook', $hogar->redes->facebook) }}">
                <p class="form-subtitulos">Usuario de Facebook</p>
            </div>

            {{-- Instagram --}}
            <div>
                <label class="block text-sm" for="instagram">Instagram</label>
                <input type="text" name="instagram" id="instagram"
                    value="{{ old('instagram', $hogar->redes->instagram) }}">
                <p class="form-subtitulos">Usuario de Instagram</p>
            </div>

            {{-- WhatsApp --}}
            <div>
                <label class="block text-sm" for="whatsapp">
                    Número de WhatsApp <span class="asterisco">*</span>
                </label>
                <input type="number" name="whatsapp" id="whatsapp" required
                    value="{{ old('whatsapp', $hogar->redes->whatsapp) }}">
            </div>

            {{-- Provincia --}}
            <div>
                <label for="provincia" class="block text-sm">Provincia *</label>
                <select id="provincia" name="provincia" required>
                    <option value="" disabled {{ old('provincia') ? '' : 'selected' }}>
                        Seleccionar provincia...
                    </option>

                    @if (old('provincia'))
                        <option value="{{ old('provincia') }}" selected>
                            {{ old('provincia') }}
                        </option>
                    @endif
                </select>
            </div>

            {{-- Localidad --}}
            <div>
                <label class="block text-sm">Localidad</label>
                <input name="localidad" class="w-full p-2 border rounded" required
                    value="{{ old('localidad', $hogar->direccion->localidad) }}">
            </div>

            {{-- Ciudad --}}
            <div>
                <label class="block text-sm">Ciudad</label>
                <input name="ciudad" class="w-full p-2 border rounded" required
                    value="{{ old('ciudad', $hogar->direccion->ciudad) }}">
            </div>

            {{-- Calle --}}
            <div>
                <label class="block text-sm">Calle y Numero</label>
                <input name="calleYAltura" class="w-full p-2 border rounded" required
                    value="{{ old('calleYAltura', $hogar->direccion->calleYAltura) }}">
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">
                Publicar
            </button>
            <a href="{{ route('admin.instituciones') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>

    </form>

@endsection
<script src="{{ asset('js/validacionDireccion.js') }}"></script>
