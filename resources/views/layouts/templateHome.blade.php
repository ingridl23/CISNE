@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cisne - Consultorios Interdisciplinarios de Salud Neuroemocional</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">

</head>

<body id="page-top">
     @if(session('success'))
            <div id="mensaje-exito" class="alert-flotante alert alert-success">
                {{ session('success') }}
            </div>
             @endif
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
                    <li class="nav-item"><a class="nav-link" href="#services">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Profesionales</a></li>
                    <li class="nav-item"><a class="nav-link" href="#hogares">Hogares</a></li>
                    <li class="nav-item"><a class="nav-link" href="#mapa">Ubicacion</a></li>
                    <li class="nav-item"><a class="nav-link btn-contact">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('novedades') }}">Novedades</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container">


        </div>
    </header>
    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Servicios</h2>
                <h3 class="section-subheading text-muted"> Consultorios Interdisciplinarios de Salud Neuroemocional</h3>
            </div>

            <!--Psicologia -->
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x icon-bg-green-pastel"></i>
                        <i class="fas fa-brain fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Consultorios especializados en psicología</h4>
                    <p class="text-muted"> Ofrecemos terapias individuales y consultorías.
                        Tu bienestar mental es nuestra prioridad.
                    </p>
                </div>

                <!--Psicopedagogia -->
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x icon-bg-green-pastel"></i>
                        <i class="fas  fa-book-open fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Espacios especializados en psicopedagogía</h4>
                    <p class="text-muted">Acompañamos a niños y adolescentes con terapias personalizadas y consultorías
                        orientadas a potenciar su aprendizaje, desarrollo y bienestar.
                    </p>
                </div>

                <!--Hogares adultos mayores -->
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x icon-bg-green-pastel"></i>
                        <i class="fas fa-hand-holding-heart fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Atención especializada para adultos mayores</h4>
                    <p class="text-muted">Brindamos acompañamiento integral en hogares, con terapias y consultorías
                        diseñadas para favorecer el bienestar emocional, cognitivo y social de las personas mayores.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- seccion carrousel con propagandas -->

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">


        <div class="carousel-inner institutos">
            <div class="carousel-item active text-center">

                <img src="{{ asset('assets/imgs/3.png ') }}" class="d-block w-100" alt="...">

            </div>


            <div class="carousel-item">
                <img src="{{ asset('assets/imgs/4.png ') }}" class="d-block w-100" alt="...">

            </div>

            <div class="carousel-item">
                <img src="{{ asset('assets/imgs/cisne.png ') }}" class="d-block w-100" alt="...">

            </div>


        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    </section>
    <br>
    <br>





    <php?>

        <!-- profesionales que trabajan en el equipo cisne-->
        <section class="page-section bg-light" id="team">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Profesionales</h2>
            </div>
            <div class="grid-profesionales">
                @foreach ($profesionales ?? [] as $profesional)
                    <div class="prof-card visible">

                        @if ($profesional->imagenes->isNotEmpty())
                            <img src="{{ $profesional->imagenes->first()->url }}"
                                alt="Foto de {{ $profesional->nombre }}" class="fotos-prof" />
                        @else
                            <img src="https://via.placeholder.com/150" alt="Sin foto" class="fotos-prof" />
                        @endif

                        <div>
                            <h3 class="nombre-profesional">{{ $profesional->nombre }}</h3>
                            <p class="especialidad">{{ $profesional->especialidad }}</p>
                            <p class="matricula">{{ $profesional->matricula }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>



        <!-- hogares con quienes colabora el consultorio-->
        <section class="page-section bg-light" id="hogares">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Hogares</h2>

                    <p class="parrafo-instituciones"> En CISNE Consultorios trabajamos mano a mano con residencias
                        geriátricas, hogares de día y centros
                        de atención para adultos mayores. Nuestro equipo interdisciplinario de psicólogos y
                        psicopedagogos
                        lleva la atención neuroemocional directamente a sus instalaciones, ofreciendo intervenciones
                        centradas
                        en el bienestar de los residentes y acompañamiento a las familias.
                    <details class="details">
                        <p> Además, brindamos asesoría y
                            capacitación al personal de cada institución para implementar prácticas
                            que fomenten un entorno más saludable y emocionalmente equilibrado. </p>
                    </details>
                    </p>
                </div>
                <div class="row">
                    @foreach ($hogares ?? [] as $hogar)
                        <div class="col-lg-4 col-sm-6 mb-4">
                            <div class="portfolio-item">
                                <a class="portfolio-link" data-bs-toggle="modal"
                                    href="#modalHogar{{ $hogar->id }}">
                                    <div class="portfolio-hover">
                                        <div class="portfolio-hover-content">
                                            {{-- <i class="fas fa-plus fa-3x"></i>   --}}
                                        </div>
                                    </div>

                                    {{-- Imagen principal del hogar --}}
                                    <img class="img-fluid" style="width: 200px; height: auto;"
                                        src="{{ $hogar->imagenes->first()->url ?? 'assets/img/portfolio/default.jpg' }}"
                                        alt="{{ $hogar->nombre }}" />
                                </a>

                                <div class="portfolio-caption">
                                    <div class="portfolio-caption-heading">{{ $hogar->nombre }}</div>
                                    <div class="portfolio-caption-subheading text-muted">
                                        {{ $hogar->descripcion ? Str::limit($hogar->descripcion, 30) : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- Mapa-->
        <br>
        <section class="page-section container px-3" id="mapa">



            <h2 class="section-heading text-uppercase text-center">¿Dónde nos encontramos?</h2>
            <p class="especialidad text-center" style="text-align: center;">Estamos Ubicados en Juan Manuel de Rosas
                1763
                km 41 Virrey
                del
                Pino, Arg</p>
            <div class="map-wrapper  ratio ratio-16x9">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3273.7245443239767!2d-58.6697974248701!3d-34.86314807124448!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcddf945702a29%3A0x4bc61a69a5a3284!2sCONSULTORIO%20CISNE!5e0!3m2!1ses!2sar!4v1750633507242!5m2!1ses!2sar"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <h2 class="section-heading text-uppercase text-center">Seguinos en nuestras redes sociales</h2>
            <div class="social-icons">



                <a href="https://www.instagram.com/consultorioscisne/" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram">
                </a>






                <a href="https://www.facebook.com/CISNEconsultorios/" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
                </a>

            </div>


        </section>


        @include('layouts.whatsapp-button')

        <!-- formulario de contacto-->

        <!-- OVERLAY -->
       
        
          
        
        </div>
        <div class="custom-modal-overlay" id="overlay"></div>
        <!-- MODAL -->
        <div class="custom-modal" id="modal">

            <div class="custom-modal-header">
                <img id="img" src="{{ asset('assets/iconos/logo_cisne_insta-removebg-preview.png') }}"
                    alt="Logo CISNE">
                <span>CONTACTO</span>
            </div>
            <button class="custom-modal-close" id="closeModal">&times;</button>

            <form class="form" method="POST" action="{{ route('enviar') }}" enctype="multipart/form-data" novalidate>
                   @csrf
                <div class="field-group">
                   <input type="text" name="name" id="name" placeholder=" " required>
                    <label for="name">Nombre y Apellido<span class="asterisco">*</span></label>

                </div>
                <div class="field-group">
                    <input type="tel" name="tel" id="telefono" placeholder=" " required>
                    <label for="tel">Teléfono<span class="asterisco">*</span></label>

                </div>
                <div class="field-group">
                   <input type="email" name="email" id="email" placeholder=" " required>
                    <label for="email">Email<span class="asterisco">*</span></label>

                </div>

                <input type="text" id="oculto"name="oculto" class="oculto" autocomplete="off" value="">

                <fieldset class="opciones">
                    <legend>¿Porque nos contactas?</legend>
                    <label><span class="asterisco">*</span><input type="radio"  name="opcion"
                            value="particular">
                        Consulta particular con
                        especialista</label>
                    <label><span class="asterisco">*</span><input type="radio"  name="opcion"
                            value="profesional">
                        Soy profesional y quiero estar en
                        Cisne </label>
                    <label><span class="asterisco">*</span><input type="radio"  name="opcion"
                            value="institucion">
                        Institucion en busqueda de
                        profesionales</label>
@if(isset($errors))
    @error('opcion')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
@endif
                
                </fieldset>

                <!-- campo para cargar CV, visible solo si busca empleo -->
                <div class="field-group campoCV">

                    <input type="file" id="cv" name="cv" accept=".pdf">
                    <label for="cv">Cargar currículum vitae PDF <span class="asterisco">*</span>
                    </label>
    @if(isset($errors))
    @error('cv')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
@endif



                </div>



                <button class="submit " type="submit" id="btn">
                    <span class="btn-text">Enviar</span>
                    <span class="checkmark">&#10004;</span>
                    <span class="checkmark2">&#10008;</span>
                </button>
                <p class="error-msg">Complete los campos obligatorios</p>
                
            </form>
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

                {{--  Mensaje de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success text-center mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                {{--  Errores generales --}}
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
                    <label for="email">Email <span class="asterisco">*</span></label>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <input type="password" name="password" id="contraseña" placeholder="" required>
                    <label for="password">Contraseña <span class="asterisco">*</span></label>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <input type="text" id="oculto2"name="oculto" class="oculto" autocomplete="off" value="">


                <button class="submit " type="submit" id="btn-admin-send">
                    <span class="btn-text">Loguearse</span>
                    <span class="checkmark">&#10004;</span>
                    <span class="checkmark2">&#10008;</span>
                </button>
                <a href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                  </a>

            </form>
        </div>




        @include('layouts.footer')
        <!-- Portfolio Modals-->
        <!-- Portfolio item 1 modal popup-->
        @foreach ($hogares ?? []  as $hogar)
            <div class="portfolio-modal modal fade" id="modalHogar{{ $hogar->id }}" tabindex="-1"
                role="dialog" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">

                        <button class="custom-modal-close" data-bs-dismiss="modal"></button>

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">

                                    <div class="modal-body">
                                        <!-- Título -->
                                        <h3 class="text-uppercase">{{ $hogar->nombre }}</h3>



                                        @if ($hogar->imagenes->first())
                                            <img class="img-fluid d-block mx-auto"
                                                src="{{ $hogar->imagenes->first()->url }}"
                                                alt="{{ $hogar->nombre }}" />
                                        @else
                                            <div class="img-fluid d-block mx-auto"
                                                style="width:300px; height:300px; background:#e5e5e5; border-radius:8px;">
                                            </div>
                                        @endif

                                        <!-- Información -->
                                        <p>
                                            @if ($hogar->descripcion)
                                                {{ $hogar->descripcion }}
                                            @endif
                                        </p>

                                        <ul class="list-inline">
                                            <li>
                                                <strong>Ciudad:</strong>
                                                {{ $hogar->direccion->ciudad ?? 'No disponible' }}
                                            </li>
                                            <li>
                                                <strong>Provincia:</strong>
                                                {{ $hogar->direccion->provincia ?? 'No disponible' }}
                                            </li>
                                        </ul>
                                        <ul class="list-inline">
                                            <!-- Subtítulo -->
                                            <p class="item-intro text-muted">
                                                Medios De Contacto Con La Institucion
                                            </p>
                                            <li>
                                                <strong>Facebook</strong>
                                                {{ $hogar->redes->facebook ?? 'No disponible' }}
                                            </li>
                                            <li>
                                                <strong>Instagram:</strong>
                                                {{ $hogar->redes->instagram ?? 'No disponible' }}
                                            </li>
                                            <li>
                                                <strong>Whatsapp:</strong>
                                                {{ $hogar->redes->whatsapp ?? 'No disponible' }}
                                            </li>

                                        </ul>



                                        <!-- Botón volver -->
                                        <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal">
                                            volver a inicio
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        @endforeach


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="js/validacionOpciones.js"></script>

</body>

</html>
