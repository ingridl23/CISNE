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
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
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


    <!-- aca todo esto deberia iterarse-->
    <div id="#noticias-container">

        <div class=" card   container-card ">





            <p <small class=" text-body-secondary">Fecha de publicación:
                {{ $noticia->created_at->format('Y-m-d') }}</small></p>
            <h2 class="noticiaTitulo">{{ $noticia->titulo }}</h2>
            @if ($noticia->imagenesNoticias)
                <img src="{{ $noticia->imagenesNoticias->url }}" class="img-noticia img-fluid "
                    alt="Imagen de la noticia: {{ $noticia->titulo }}">
            @else
                <div class="w-14 h-14 bg-gray-200 rounded-full"></div>
            @endif

            <div class="card-body">
                <p class="card-text-noticia">{!! nl2br($noticia->descripcion) !!}
                </p>


            </div>
        </div>


    </div>

    <!-- modal del formulario para el acceso administrativo ---->
    <!-- OVERLAY -->
    <div class="custom-modal-overlay" id="overlay-admin"></div>

    <!-- MODAL -->
    <div class="custom-modal" id="modal-admin">
        <div class="custom-modal-header">
            <img id="" src="{{ asset('assets/iconos/logo_cisne_insta-removebg-preview.png') }}"
                alt="Logo CISNE">
            <span>PANEL PARA ADMINISTRADOR</span>

            {{-- ✅ Mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success text-center mb-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✅ Errores generales --}}
            @if ($errors->any())
                <div class="text-center mb-3 alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <button class="custom-modal-close" id="close-admin">&times;</button>

        <form id="form-admin" class="form" method="POST" action="{{ route('login') }}" novalidate>
            @csrf
            <div class="field-group">
                <input type="email" name="email" id="email2" placeholder=" " required>
                <label for="name">Email <span class="asterisco">*</span></label>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="field-group">
                <input type="password" name="password" id="contraseña" placeholder="" required>
                <label for="email">Contraseña <span class="asterisco">*</span></label>
                @error('contraseña')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <input type="text" id="oculto2"name="oculto" class="oculto" autocomplete="off" value="">


            <button class="submit " type="submit" id="btn-admin-send">
                <span class="btn-text">Loguearse</span>
                <span class="checkmark">&#10004;</span>
                <span class="checkmark2">&#10008;</span>
            </button>
            <a
                id="olvidastepass"href="https://wa.me/542983547406?text=¡Hola me comunico desde el sitio de CISNE para recuperar la contraseña, muchas gracias.">
                ¿olvidaste la contraseña?</a>

        </form>
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


    <script src="{{ asset('js/carteles/carteles_error_success.js') }} "></script>
    <script src="{{ asset('js/scripts.js') }}"></script>


    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
