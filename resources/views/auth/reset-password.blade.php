@extends('layouts.guest')

@section('title', 'Restablecer contraseña')

@section('content')

<h2 class="text-xl font-bold mb-4">Restablecer contraseña</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <label for="email" class="block mb-1">Email</label>
    <input
        id="email"
        type="email"
        name="email"
        value="{{ old('email', $request->email) }}"
        class="w-full border p-2 rounded mb-3"
        required
        autofocus
    >

    <label for="password" class="block mb-1">Nueva contraseña</label>
    <input
        id="password"
        type="password"
        name="password"
        class="w-full border p-2 rounded mb-3"
        required
        autocomplete="new-password"
    >

    <label for="password_confirmation" class="block mb-1">Confirmar contraseña</label>
    <input
        id="password_confirmation"
        type="password"
        name="password_confirmation"
        class="w-full border p-2 rounded mb-3"
        required
        autocomplete="new-password"
    >

    <button class="w-full bg-emerald-600 text-white p-2 rounded">
        Restablecer contraseña
    </button>
</form>

@endsection
