@extends('layouts.guest')

@section('content')

<h2 class="text-xl font-bold mb-4">Recuperar contraseña</h2>

{{-- ERRORES (forma segura) --}}
@if (session('errors'))
    <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
        @foreach (session('errors')->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- STATUS --}}
@if (session('status'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <input
        type="email"
        name="email"
        value="{{ old('email') }}"
        placeholder="Tu email"
        class="w-full border p-2 rounded mb-3"
        required
    >

    <button class="w-full bg-emerald-600 text-white p-2 rounded">
        Enviar enlace
    </button>
</form>

@endsection