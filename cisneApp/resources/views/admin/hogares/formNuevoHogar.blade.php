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


        <div class="grid  gap-4">

            <div>
                <label class="block text-sm">Imagen (Portada)</label>
                <input type="file" name="imagen" accept="image/*" class="w-full" id="imagen"required>


            </div>
            <div>
                <label class="block text-sm">Nombre</label>
                <input name="nombre" class="w-full p-2 border rounded" id="nombre" required>
            </div>

            <div>
                <label class="block text-sm">Descripcion</label>
                <input name="descripcion" class="w-full p-2 border rounded" id="especialidad " required>
            </div>



            <div <label class="block text-sm" for="facebook">Facebook</label>
                <input type="text" name="facebook" id="facebook" placeholder=""
                    value="{{ isset($institucion) ? $institucion->redes->facebook : '' }}">

                <p class="form-subtitulos">Si posee usuario de facebook,ingrese el nombre de usuario</p>
            </div>
            <div>
                <label class="block text-sm" for="instagram">Instagram</label>
                <input type="text" name="instagram" id="instagram" placeholder=""
                    value="{{ isset($institucion) ? $institucion->redes->instagram : '' }}">

                <p class="form-subtitulos">Si posee usuario de Instagram, ingrese el nombre de usuario</p>
            </div>
            <div>
                <label class="block text-sm" for="whatsapp">Número de WhatsApp <span class="asterisco">*</span></label>
                <input type="number" name="whatsapp" id="whatsapp" required placeholder=""
                    value="{{ isset($institucion) ? $institucion->redes->whatsapp : '' }}">

            </div>
            <p class="form-subtitulos">Ingresar un número de telefono del emprendedor/ra</p>



            <div class="provincias-del-pais">
                <label for="provincia" class="block text-sm text-gray-700">
                    Provincia <span class="asterisco">*</span>
                </label>

                <select id="provincia" name="provincia" required>
                    <option value="" disabled selected>Seleccionar provincia...</option>

                    {{-- Si estás editando una institución --}}
                    @if (isset($institucion))
                        <option value="{{ $institucion->direccion->provincia }}" selected class="opcionValorCargado">
                            {{ $institucion->direccion->provincia }}
                        </option>
                    @endif
                </select>


            </div>


            <div>
                <label class="block text-sm">Ciudad</label>
                <input name="ciudad" class="w-full p-2 border rounded" id="ciudad" required>

            </div>

            <div>
                <label class="block text-sm">Calle y Numero</label>
                <input name="calleYAltura" class="w-full p-2 border rounded" id="calleYAltura" required>

            </div>

        </div>



        <div class="mt-4">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded crear">Publicar</button>
            <a href="{{ route('admin.instituciones') }}" class="ml-2 text-gray-600">Cancelar</a>
        </div>

    </form>

@endsection
