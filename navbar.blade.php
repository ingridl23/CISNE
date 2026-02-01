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
                                <a class="nav-link" href="{{ url('/profesionales') }}">Profesionales</a>
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
