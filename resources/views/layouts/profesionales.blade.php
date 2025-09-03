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
    <link href="{{ asset('css/sectionredes.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet" />


</head>

<body>

    <!-- Navigation-->
<div class="custom-navbar-container">
    <header id="header" class="fixed-top header-scrolled">
        <div class="container-fluid px-4 container">
            <!-- Navbar principal -->
            <nav class="navbar navbar-expand-lg navbar-light fixed-top py-2" id="mainNav">
                <div class="container px-4 px-lg-5 d-flex align-items-center justify-content-between">

                    <!-- Logo y marca -->
                    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                        <img src="{{ asset('assets/img/logocisne.png') }}"
                            alt="Logo Cisne" class="logo-img me-2">
                        <span class="brand-text"></span>
                    </a>

                    <!-- Botones de toggle para móvil -->
                    <button class="navbar-toggler navbar-toggler-right d-lg-none" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Menú de navegación principal -->
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav mx-auto my-2 my-lg-0">
                            <li class="nav-item">
                                <a class="nav-link"href="{{ url('/servicios') }}">Servicios</a>
                            </li>
                
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/hogares') }}">Hogares</a>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link" href="{{ url('/novedades') }}">Novedades</a>
                         
                            @if (Auth::check() && Auth::user()->hasRole('admin'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/panel') }}">Panel Configuracion</a>
                                </li>
                            @else
                                <li class="nav-item serParte">
                                    <a class="nav-link" href="{{ url('/contacto') }}">Contacto</a>
                                </li>
                            @endif
                        </ul>

                        <!-- Botones de servicios externos -->
                        <div class="get-started-buttons d-flex align-items-center">
                           
                            @if (Auth::check() && Auth::user()->hasRole('admin'))
                                <form action="/logout" method="post"
                                    class="get-started-btn scrollto btn-contact cerrarSesion">
                                    @csrf
                                    <button type="submit">
                                        <div class="get-started-group font-color-bl containerLinksExternos">
                                            <i class="fa fa-user-circle img-btn-logonav servicio-icono  "></i>
                                            <span class="btn-text">cerrar<br>sesion</span>
                                        </div>
                                    </button>
                                </form>
                            @else
                                <a href="{{ url('/showlogin') }}" class="get-started-btn scrollto btn-contact">
                                    <div class="get-started-group font-color-bl containerLinksExternos">
                                        <i class="fa fa-user-circle img-btn-logonav servicio-icono  ">
                                        </i>
                                        <span class="btn-text">Panel<br>Admin</span>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</div>

<!-- End Header -->

    <!--  ********************************************************************* -->

<section id="profesionales" class="container">
  
<div>

  <h2 class="section-tittle">Profesionales</h2>

</div>
<br>
    <div class="grid-profesionales">

      <div class="prof-card">
        <img class="fotos-prof" src="img/1001148523.jpg">
       <div>
         <h3 class="nombre-profesional">Sandra Gallo</h3>
         <p class="especialidad">Lic.Psicologia</p>
         <p class="matricula">MN 39.334</p>

       </div>
        
              </div>
    
              
<!--
    <div class="prof-card">
        <img class="fotos-prof" src="img/valefoto.jpg">
         <div>
         <h3 class="nombre-profesional">Valeria Adorno</h3>
         <p class="especialidad">Lic.Psicopedagogia</p>
         <p class="matricula">MP 150.864</p>

       </div>
    </div>

 <div class="prof-card">
        <img class="fotos-prof" src="img/1001141649.jpg">
       <div>
         <h3 class="nombre-profesional">Paula Mariel Rodriguez</h3>
         <p class="especialidad">Lic.Psicologia</p>
         <p class="matricula">MN 84.450</p>

       </div>
    </div>

    <div class="prof-card">
        <img class="fotos-prof"  src="img/1001141656.jpg">
         <div>
         <h3 class="nombre-profesional">Veronica Darwich</h3>
         <p class="especialidad">Lic.Psicopedagogia</p>
         <p class="matricula">MP 109.771</p>

       </div>
    </div>


 <div class="prof-card">
        <img class="fotos-prof"  src="img/1001141861.jpg">
          <div>
         <h3 class="nombre-profesional">Jennifer Pasinato</h3>
         <p class="especialidad">Lic.Psicologia</p>
         <p class="matricula">MP:85.592 MN:73.181</p>

       </div>
    </div>

    <div class="prof-card">
        <img  class="fotos-prof" src="img/1001147637.jpg">
       <div>
         <h3 class="nombre-profesional">Paula Buri</h3>
         <p class="especialidad">Lic.Psicologia</p>
         <p class="matricula">MP: 86886</p>

       </div>
    </div>


      <div class="prof-card">
        <img class="fotos-prof"  src="img/1001147714.jpg">
         <div>
         <h3 class="nombre-profesional">Soledad Galvan</h3>
         <p class="especialidad">Lic.Psicologia</p>
         <p class="matricula">MN:54.399 MP:83.911</p>

       </div>
    </div>

 <div class="prof-card">
        <img class="fotos-prof"  src="img/1001167380.jpg">
         <div>
         <h3 class="nombre-profesional">Cecilia Mogio</h3>
         <p class="especialidad">Lic.Psicologia</p>
         <p class="matricula">MN:62.584 MP:85.270</p>

       </div>
-->
    </div>

    </div>


</section>

</body>

@include('layouts.footer')
</html>

