<div class="grid-profesionales">
    @foreach ($profesionales as $profesional)
        <div class="prof-card visible">
            <img src="{{ $profesional->imagen ?? 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=1361&q=80' }}"
                alt="Foto de {{ $profesional->nombre }}" class="fotos-prof" />

            <div>
                <h3 class="nombre-profesional">{{ $profesional->nombre }}</h3>
                <p class="especialidad">{{ $profesional->especialidad }}</p>
                <p class="matricula">{{ $profesional->matricula }}</p>
            </div>
        </div>
    @endforeach
</div>
