# Desarrollo Web Para Consultorios Cisne - Sistema web

**Tres Arroyos, 2025**

## Descripción

# 🦢 CISNE Consultorios

> Proyecto web y panel de administración para Cisne Consultorios.

---

## 📖 Descripción

Este repositorio contiene dos secciones:

1. **Sitio público**: portal informativo con secciones de:

    - Servicios
    - Profesionales
    - Contacto (formulario con animaciones)
    - Ubicación
    - Instituciones
    - Noticias (buscador y filtros por categoría)
    - Recuperación de cuenta (reset de contraseña)

2. **Panel Admin**: interfaz privada para gestionar:

    - Flyers
    - Carrusel de imágenes
    - Profesionales (nombre, info, foto)

Ambas partes están desarrolladas con **HTML5**, **CSS3** (Flexbox / Grid) y **JavaScript (ES6)**, integrando **Bootstrap 5** para estilos básicos.

---

## 🛠️ Tecnologías

-   **HTML5**
-   **CSS3** (Flexbox, Grid, Media Queries)
-   **JavaScript (ES6)**
-   **Bootstrap 5**
-   \*\* PHP 6
-   \*\* Laravel 5

---

## 📂 Estructura del Proyecto a modificar

```text
/ (raíz)
├── index.html             # Página principal
├── publicacion.html       # Sección Noticias
├── resetlogin.html        # Recuperar contraseña
├── indexadmin.html        # Panel Admin - login previo
├── dashboard.html         # Admin Dashboard
├── flyers.html            # Gestión de Flyers
├── carousel.html          # Gestión de Carrusel
├── professionals.html     # Gestión de Profesionales
│
├── css/
│   ├── styles.css         # Estilos sitio público
│   ├── noticias.css       # Estilos sección Noticias
│   ├── stylesreset.css    # Estilos resetlogin.html
│   └── cssadmin.css       # Estilos panel Admin
│
├── js/
│   ├── logica.js          # Lógica general (modales, menús)
│   └── admin.js           # Lógica Panel Admin
│
├── img/                   # Imágenes y recursos estáticos
└── README.md              # Documentación de este proyecto
```

---

## 🚀 Instalación y Ejecución

1. Clonar este repositorio:

    ```bash

    ```

git clone <url-del-repositorio>
cd CisneConsultorios

````

2. Abrir `index.html` en un navegador, o servir con `Live Server` / `http-server`:
   ```bash
npm install -g http-server
http-server .
````

3. Abrir `http://localhost:8080` (o el puerto que muestre) en tu navegador.

---

## 🎯 Uso del Sitio Público

-   Navega por el menú superior o en móvil haz click en el ícono `☰`.
-   Envía mensajes desde el formulario de **Contacto**.
-   Recupera tu cuenta en `resetlogin.html`.
-   Explora **Noticias** con buscador y filtros.

---

## 🔐 Panel de Administración

1. Accede al panel mediante el avatar de admin en el header.
2. El panel verifica `sessionStorage.isAdmin` y redirige al login si no existe.
3. Usa el menú lateral para seleccionar módulos:

    - **Dashboard**
    - **Flyers**
    - **Carrusel**
    - **Profesionales**

4. Haz click en tu avatar para desplegar **Editar perfil** / **Cerrar sesión**.

---

## 🧩 Módulos y Funcionalidades

| Módulo                                                     | Descripción                             |
| ---------------------------------------------------------- | --------------------------------------- |
| Flyers                                                     | Añadir/editar título e imagen de flyers |
| Carrusel                                                   | CRUD de slides con leyenda e imagen     |
| Profesionales                                              | CRUD de perfiles (nombre, info, foto)   |
| Instituciones Añadir/editar referencias de info e imagenes |

---

## 👤 Autor

**Ingrid Ledesma** –Tecnica en desarrollo de aplicaciones informaticas – CISNE Consultorios

---

## 📄 Licencia

MIT © 2025 Cisne Consultorios

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Cubet Techno Labs](https://cubettech.com)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[Many](https://www.many.co.uk)**
-   **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
-   **[DevSquad](https://devsquad.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[OP.GG](https://op.gg)**
-   **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
-   **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
