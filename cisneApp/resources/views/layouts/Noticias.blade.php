<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cisne-Novedades</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="{{ asset('css/noticias.css') }}">
    <link rel="stylesheet" href="{{ asset('css/noticiaIndividual.css') }}">
    <link href="{{ asset('css/acordeon.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top"><img id="logocisne"
                    src="{{ asset('assets/iconos/logo_cisne_insta-removebg-preview.png') }}" alt="imagen logo" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">

                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <h3 class="nav-item text-center">Novedades</h3>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Volver a inicio</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->

    <header class="masthead">
        <div class="container">

        </div>
    </header>

    <div class="container px-4 px-lg-5 h-100">

        <div class="col-lg-8 align-self-end">
            <h1 class="text-white font-weight-bold subtitulo-page">Noticias y Novedades</h1>
        </div>
        <div class="col-lg-8 align-self-baseline">
            <p class="text-white-75 ">
                Mantente al día con la información más reciente de Consultorios Cisne.
                En esta sección encontrarás actualizaciones sobre turnos, y
                oportunidades laborales disponibles en nuestra compañia profesional.
            </p>

            <p class="text-white-75 ">
                Un espacio pensado para que puedas acceder a información
                útil y aprovechar al
                máximo las iniciativas y recursos que ponemos a tu disposición.
            </p>
            <br>

        </div>
    </div>

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
                    <button class="buttonSearch botonFiltro"> <img
                            id= "img-lupa"src="{{ asset('assets/iconos/lupa.png') }}" title="lupa"></button>
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
                    <button class="buttonSearch botonFiltro"> <img
                            id= "img-lupa"src="{{ asset('assets/iconos/lupa.png') }}" title="lupa"></button>
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
                    <button class="buttonSearch botonFiltro"> <img
                            id= "img-lupa"src="{{ asset('assets/iconos/lupa.png') }}" title="lupa"></button>
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
    <script src="{{ asset('js/noticias/buscarNoticias.js') }} "></script>
    <script src="{{ asset('js/carteles/carteles_error_success.js') }} "></script>
    <script src="js/scripts.js"></script>
</body>

</html>
