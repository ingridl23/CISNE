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
                @foreach ($profesionales as $profesional)
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
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- Portfolio item 1-->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal1">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" src="assets/img/portfolio/1.jpg" alt="..." />
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading">Threads</div>
                                <div class="portfolio-caption-subheading text-muted">Illustration</div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <!-- Mapa-->
        <br>
        <section class="page-section container px-3" id="mapa">



            <h2 class="section-heading text-uppercase text-center">Donde nos encontramos</h2>
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
        <div class="custom-modal-overlay" id="overlay"></div>

        <!-- MODAL -->
        <div class="custom-modal" id="modal">
            <div class="custom-modal-header">
                <img id="img" src="{{ asset('assets/iconos/logo_cisne_insta-removebg-preview.png') }}"
                    alt="Logo CISNE">
                <span>CONTACTO</span>
            </div>
            <button class="custom-modal-close" id="closeModal">&times;</button>

            <form class="form" novalidate>
                <div class="field-group">
                    <input type="text" id="name" placeholder=" " required>
                    <label for="name">Nombre y Apellido<span class="asterisco">*</span></label>

                </div>
                <div class="field-group">
                    <input type="tel" id="telefono" placeholder=" " required>
                    <label for="telefono">Teléfono<span class="asterisco">*</span></label>

                </div>
                <div class="field-group">
                    <input type="email" id="email" placeholder=" " required>
                    <label for="email">Email<span class="asterisco">*</span></label>

                </div>

                <input type="text" id="oculto"name="oculto" class="oculto" autocomplete="off" value="">

                <fieldset class="opciones">
                    <legend>¿Porque nos contactas?</legend>
                    <label><span class="asterisco">*</span><input type="radio" id="opcion1" name="opciones"
                            value="particular">
                        Consulta particular con
                        especialista</label>
                    <label><span class="asterisco">*</span><input type="radio" id="opcion2" name="opciones"
                            value="profesional">
                        Soy profesional y quiero estar en
                        Cisne </label>
                    <label><span class="asterisco">*</span><input type="radio" id="opcion3" name="opciones"
                            value="institucion">
                        Institucion en busqueda de
                        profesionales</label>

                    @error('opciones')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </fieldset>

                <!-- campo para cargar CV, visible solo si busca empleo -->
                <div class="field-group">

                    <input type="file" id="cv" name="cv" accept=".pdf">
                    <label for="cv">Cargar currículum vitae PDF <span class="asterisco">*</span>
                    </label>
                    @error('cv')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror


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




        @include('layouts.footer')
        <!-- Portfolio Modals-->
        <!-- Portfolio item 1 modal popup-->
        <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button class="custom-modal-close" data-bs-dismiss="modal"> </button>

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Hogar numero uno</h2>
                                    <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/1.jpg"
                                        alt="..." />
                                    <p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur
                                        adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos
                                        deserunt
                                        repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores
                                        repudiandae,
                                        nostrum, reiciendis facere nemo!</p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>Client:</strong>
                                            Threads
                                        </li>
                                        <li>
                                            <strong>Category:</strong>
                                            Illustration
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                        type="button">
                                        volver a inicio
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="js/validacionOpciones.js"></script>

</body>

</html>
