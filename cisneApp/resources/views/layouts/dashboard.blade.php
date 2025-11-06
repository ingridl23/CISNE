@extends('admin.layouts')

@section('title', 'Panel')

@section('panel-content')

    <div class="space-y-6">

        <h2 class="text-xl font-bold text-gray-700">
            Bienvenida, {{ Auth::user()->name }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Profesionales --}}
            <div class="p-6 rounded-lg shadow bg-sky-100 border-sky-300">
                <h3 class="text-lg font-semibold text-sky-800">Profesionales</h3>
                <p class="text-3xl font-bold">{{ $totalProfesionales ?? 0 }}</p>
            </div>

            {{-- Noticias --}}
            <div class="p-6 rounded-lg shadow bg-emerald-100 border-emerald-300">
                <h3 class="text-lg font-semibold text-emerald-800">Noticias</h3>
                <p class="text-3xl font-bold">{{ $totalNoticias ?? 0 }}</p>
            </div>

        </div>
    </div>

@endsection
