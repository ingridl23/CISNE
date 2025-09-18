@include('layouts.navBar')

<h3 class="tituloFiltroNoticias subtitulo-page">Filtrar noticias según:</h3>
<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                Tìtulo
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="search accordion-body">
                <input class="inputSearch inputFiltrosNoticias" id="Titulo" type="text"
                    placeholder="Buscar por título">
                <button class="buttonSearch botonFiltro"> <img id= "img-lupa"src="{{ asset('assets/iconos/lupa.png') }}"
                        title="lupa"></button>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Categoria
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
            data-bs-parent="#accordionExample">
            <div class="search accordion-body">
                <input class="inputSearch inputFiltrosNoticias" id="Categoria" type="text"
                    placeholder="Buscar por categoria">
                <button class="buttonSearch botonFiltro"> <img id= "img-lupa"src="{{ asset('assets/iconos/lupa.png') }}"
                        title="lupa"></button>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Fecha de publicación
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
            data-bs-parent="#accordionExample">
            <div class="search accordion-body">
                <input class="inputSearch inputFiltrosNoticias" id="Fecha" type="date"
                    placeholder="Buscar por fecha de publicación">
                <button class="buttonSearch botonFiltro"> <img id= "img-lupa"src="{{ asset('assets/iconos/lupa.png') }}"
                        title="lupa"></button>
            </div>
        </div>
    </div>
</div>

<div id="noticias-container"></div>

<!-- aca todo esto deberia iterarse-->
<div class="container-fluid">

    @foreach ($noticias as $noticia)
        <div class="row container-card ">

            <!-- Mostrar cada noticia -->


            <div class="card mb-3">
                <img src="{{ $noticia->imagen }}" class="card-img-top1" alt={{ $noticia->titulo }}>
                <div class="card-body">
                    <h5 class="card-title">{{ $noticia->titulo }}</h5>
                    <p class="card-text">{{ $noticia->categoria }}</p>
                    <div class="container-vermas">
                        <p class="card-text"><small class="text-body-secondary">Publicación :
                                {{ $noticia->created_at->format('Y-m-d') }}</small></p>
                        <p class="card-text"><small class="text-body-secondary">Última Actualización :
                                {{ $noticia->updated_at->format('Y-m-d') }}</small></p>
                        <button class="vermas"><a href="noticias/{{ $noticia->id }}">Ver más</a></button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="navegacionPags">
    {{ $noticias->onEachSide(2)->links('pagination::bootstrap-4') }}
</div>

</div>

<!-- barra de navegacion footer -->
@include('layouts.footer')

@if (session('success'))
    <script>
        window.mensajeExito = @json(session('success'));
    </script>
@endif

@if (session('error'))
    <script>
        window.mensajeError = @json(session('error'));
    </script>
@endif
