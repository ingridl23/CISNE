<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cisne Consultorios</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />

    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styleslogin.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/form.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/sectionredes.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet" />


</head>

<body id="page-top">
    <!-- Navigation-->

<!-- barra de navegacion -->
    @include('layouts.navBar')
    <!--  ********************************************************************* -->



    <!-- Masthead-->
    <header class="masthead headerHome">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">CONSULTORIOS INTERDISCIPLINARIOS DE SALUD NEUROEMOCIONAL </h1>
                </div>
            
            </div>

    </header>

    <!-- About-->
    <section class="page-section custom-about" id="about">


        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <p class="text-white-75 mb-5">Contamos con especialistas en neurociencia capacitados para la atencion en infantes y adultos.
                      </p>

                    <p class="text-white-75 mb-5">Te invitamos a recorrer nuestra página y conocer los servicios que ofrecemos.

                    </p>

                    <h2 class="text-white mt-0">¿Quiénes pueden participar?</h2>
                    <hr class="divider divider-light" />
                    <p class="text-white-75 ">


                    <details class="details btn btn-light">
                        <p> Contamos con un  programa de socios para hogares de personas mayores.buscamos llevar nuestra labor y profesionalismo a quienes más lo necesitan. 
                        

                    </details>
                    </p>

                </div>
            </div>
        </div>



    </section>
    <!-- Services-->
    <section class="page-section section-services" id="services">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">Servicios que ofrecemos </h2>

            <div class="row justify-content-center  align-baseline">
                <div class="col-lg-6 col-md-6 text-center seccion-tenes-emprendimiento">
                    <div class="mt-5">
                        <div class="mb-2"><i class=" fs-1 text-primary"  style="color:#004d4d!important;"></i>
                        </div>
                        <img src="{{ asset('assets/img/iconos/persona.png') }}" class="divider">
                        <h3 class="h4 mb-2">Psicopedagogia</h3>
                        <p class="text-muted mb-0">Consulta por un turno y asesorarte acerca de los tratamientos para tus seres queridos en Atención psicopedagógica</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 text-center seccion-tenes-emprendimiento">
                    <div class="mt-5">
                        <div class="mb-2"><i class=" fs-1 text-primary"  style="color:#004d4d!important;"></i>
                        </div>
                        <img src="{{ asset('assets/img/iconos/terapia.png') }}" class="divider">
                        <h3 class="h4 mb-2">Psicología</h3>
                        <p class="text-muted mb-0">Brindamos asistencia psicologica a niños, adolescentes y adultos.</p>
                            </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 text-center seccion-tenes-emprendimiento">
                    <div class="mt-5">
                        <div class="mb-2"><i class=" fs-1 text-primary"  style="color:#004d4d!important;"></i>
                        </div>
                        <br>
                        <img src="{{ asset('assets/img/iconos/curriculum-vitae.png') }}" class="divider">
                        <h3 class="h4 mb-2">¿Queres sumarte a nuestro equipo profesional?</h3>

                        <p class="text-muted mb-0">Recibimos tu CV y llevamos adelante la intermediación laboral.</p>
                    </div>
                </div>

                
            </div>



        </div>


    </section>

    @include('layouts.profesionales')
    <br>
    <br>
    @include('layouts.hogares')
    <br>
    <br>
    @include('layouts.seccionredesYUbicacion')


    <a href="https://wa.me/2983603748?text=¡Hola, contactanos a traves de nuestro whatsapp, muchas gracias , oficina de empleo"
        class="whatsapp-float" target="_blank" rel="noopener">

        <img class="whatsapp" src="assets/img/iconos/whatsapp.png">
    </a>



    <!-- barra de navegacion footer -->
    @include('emprendedor.footer')

    <!--JQuery para el manejo de link internos en Programas-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Bootstrap core JS-->
    <script src="{{ asset('js/scripts.js') }} "></script>

    <script src="{{ asset('js/navbar.js') }} "></script>
    <script src="{{ asset('js/carruselProgramasLinks.js') }} "></script>



    <!-- SimpleLightbox plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <!-- Core theme JS-->

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!--Carrusel-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


</html>
