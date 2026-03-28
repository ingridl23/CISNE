# Desarrollo Web Para Consultorios Cisne - Sistema web

![Logo CISNE](./public/assets/logo_cisne_insta-removebg-preview.png)

## Objetivo
#Descripción del Proyecto

CISNE Consultorios es un sistema web integral diseñado para la gestión y difusión de servicios profesionales dentro de un entorno de consultorios. La plataforma combina un sitio público informativo con un panel administrativo, permitiendo centralizar la información institucional, mejorar la comunicación con los usuarios y optimizar la gestión interna.

El sistema está orientado a brindar una experiencia clara y accesible tanto para pacientes como para profesionales, facilitando el acceso a información relevante sobre servicios, especialistas y novedades.

🔹 Funcionalidades principales
Gestión de profesionales: alta, edición y visualización de especialistas, incluyendo su información profesional e imágenes asociadas.
Módulo de noticias: publicación de novedades categorizadas con contenido multimedia.
Administración de hogares/instituciones: gestión de información institucional, direcciones y redes sociales.
Carga y gestión de imágenes: asociación de recursos visuales a distintas entidades del sistema.
Gestión de pacientes: registro básico de datos de contacto.
Sistema de autenticación y roles: control de acceso mediante usuarios, roles y permisos.
Recepción de contactos y postulaciones: registro de instituciones y profesionales que desean comunicarse o enviar CV.


El objetivo principal del sistema es digitalizar y centralizar la gestión de consultorios, proporcionando una herramienta eficiente para la administración interna y una interfaz amigable para los usuarios externos.


## Instalación y ejecución 🚀

### Requisitos previos
-   Laravel": "^8.0
-   PHP <= 8.3.29
-   Composer
-   Node.js + npm": "^10.8.2
-   MySQL o MariaDB": "^5.7.33
-   Laragon": "^5.0.0 / XAMPP / WAMP
-   Vite": "^7.0.7
-   TailwindCSS": "^3.1.0 
-   Fontawesome": "^7.0
-   AlpineJS": "^3.0.6
-   ChartJS": "^4.5.1
-   Maatwebsite/excel": "^3.1"
-   Cloudinary": "^2.14"


### Pasos Para La Instalacion

1. Clonar el repositorio:

    ```bash
    git clone https://github.com/ingridl23/CISNE.git
    cd CISNE
    ```

2. Instalar dependencias de laravel y Frontend

    ```bash
    composer install
    npm install && npm run dev
    ```

3. Configurar el entorno

```bash
 cp .env.example .env
```

4.Generar la clave de aplicacion y generar la base de datos

```bash
php artisan key:generate
php artisan migrate --seed
```

5.Levantar el Servidor

```bash
php artisan serve

---

## 📂 Estructura del Proyecto General


Este proyecto sigue la estructura estándar de Laravel, organizada para mantener una separación clara entre la lógica de negocio, la configuración, las vistas y los recursos públicos.

Descripción de carpetas y archivos

-   **`app/`** –
    Contiene el núcleo de la aplicación, incluyendo controladores, modelos, middleware y otros elementos relacionados con la lógica de negocio.
-   **`Http/`**
    Incluye la capa de control y gestión de las peticiones HTTP.

-   `Controllers` – Controladores que procesan solicitudes y devuelven respuestas.

    -   `Middleware` – Filtros que procesan solicitudes antes o después del controlador.

    -   `Requests` – Clases para validar datos de entrada de formularios y peticiones.

-   **`Mail/`** – Clases para la gestión y envío de correos electrónicos.

    -   **`Models/`** – Representación de las entidades y su interacción con la base de datos. Ejemplos: Direccion, Emprendedor, Imagen, Noticia, Red, User.

-   **`Providers/`** – Registro y configuración de servicios del framework.

-   **`View/Components/`** – Componentes reutilizables para las vistas.

-   **`bootstrap/`** –
    Archivos de inicialización del framework y configuración del arranque de la aplicación.

-   **`config/`** –
    Archivos de configuración general del proyecto (base de datos, correo, servicios, etc.).

-   **`database/`** –
    Migraciones, seeders y factories para gestionar la estructura y datos de la base de datos.
-   **`node_modules/`** –
    Dependencias instaladas mediante Node.js, utilizadas para compilación y construcción de recursos frontend.

-   **`public/`** –
    Carpeta accesible públicamente donde se almacenan archivos compilados (CSS, JS, imágenes) y el archivo de entrada index.php.

-   **`resources/`** –
    Contiene los recursos sin procesar utilizados en el frontend.

-   `views/` – Vistas Blade.
-   `css/` – Estilos personalizados.
-   `js/` – Scripts personalizados.
-   `lang/` – Archivos de traducción.
-   `sass/` – Estilos SASS/SCSS.

-   **`routes/`** – Definición de rutas.

    -   `web.php` – Rutas para solicitudes HTTP web.

-   **`.env`** – Variables de entorno y configuración sensible.

-   **`README.md`** – Documentación del proyecto.

### Estructura de archivos


```
├── app/
   |_______http/
     |__ Controllers
     |__ Middleware
     |__ Requests
   |_______Mail/
   |_______Models/
     |__CategoriasNews
     |__direccionHogarModel
     |__hogarModel
     |__imagesFlyersModel
     |__imagesHogarModel
     |__imagesNoticiasModel
     |__imagesProfesionalesModel
     |__InstitucionContacto
     |__noticiasModel
     |__Paciente_contacto
     |__profesionalesModel
     |__redesHogarModel
     |__redesHogarModel
     |__User
     |__Visita
   |______Notifications/
   |______Policies/
   |______Providers/
   |______View/
     |__Components
|__boostrap/
|__config/
├── database/
|__documentacion/
|__node_modules/

├── public/
├──────css/
│       ├── style.css         # Estilos sitio público
│       ├── noticias.css       # Estilos sección Noticias
│       ├── styles2.css
│       └── noticiaIndividual.css      
│       └── app.css   
├────── js/
│   ├── scripts.js         # Lógica general (modales, menús)
│   └── app.js             # Lógica Panel Admin
|   |__ validacionDireccion.js #Logica select del formulario alta de hogares
│   |__ validacionOpciones.js  #Logica select del formulario de Contacto
|   |__carteles/
|   |__noticias/
|   |____buscarNoticias.js
|   |____envioImagenesNoticias.js
|
├───────assets/
├──── iconos/ # imagenes y recursos iconos o avatars
├──── imgs/                   # Imágenes y recursos estáticos
└── README.md              # Documentación de este proyecto
```


##Secciones

Este repositorio contiene dos secciones:

1. **Sitio público**: portal informativo con secciones de:

    - Servicios
    - Profesionales
    - Contacto (formulario con animaciones)
    - Ubicación y Redes Sociales
    - Instituciones
    - Noticias (buscador y filtros por categoría)

2. **Panel Admin**: interfaz privada para gestionar:

    - Panel de Estadisticas Y Descarga de Datos Formato CSV
    - Comunicados (titulo,descripcion,tipo de publicacion,foto,fecha)
    - Profesionales (nombre, info, foto)
    - Instituciones (nombre,foto,descripcon,redes sociales,ubicacion y contacto)

---



## 🎯 Uso del Sitio Público

-   Navega por el menú superior o en móvil haz click en el ícono `☰`.
-   Envía mensajes desde el formulario de **Contacto**.
-   Recupera tu cuenta en `olvidaste contraseña`.
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



---

## 🧩 Módulos y Funcionalidades

| Módulo        | Descripción                              |
| ------------- | ---------------------------------------- |
| Comunicados   | Alta/Baja/Modificacion                   |
| Profesionales | Alta/Baja/Modificacion                   |
| Instituciones | Alta/Baja/Modificacion                   |
| Estadisticas  | Informacion del ultimo mes,grafico y CSV |

## | ----------------------------------------------------------------------------------------------------



## 📍 Rutas

### Publicas
```
| Método   | URI                         | Nombre        | Descripción                     |
|----------|-----------------------------|--------------|---------------------------------|
| GET      | /                           | home         | Página principal                |
| GET      | novedades                   | novedades    | Listado de noticias             |
| GET      | noticias/{id}               | -            | Ver detalle de noticia          |
| GET      | noticias/buscadorCategoria  | -            | Filtrar por categoría           |
| GET      | noticias/buscadorFecha      | -            | Filtrar por fecha               |
| GET      | noticias/buscadorTitulo     | -            | Filtrar por título              |
| GET      | formar/parte                | -            | Formulario de contacto/CV       |
| POST     | contacto                    | enviar       | Enviar formulario de contacto   |

```
### Autenticacion
```
| Método | URI                  | Nombre            | Descripción              |
|--------|----------------------|------------------|--------------------------|
| GET    | login                | login            | Formulario de login      |
| POST   | login                | login            | Iniciar sesión           |
| POST   | logout               | logout           | Cerrar sesión            |
| GET    | register             | register         | Registro de usuario      |
| POST   | register             | -                | Crear usuario            |
| GET    | forgot-password      | password.request | Recuperar contraseña     |
| POST   | forgot-password      | password.email   | Enviar email recuperación|
| GET    | reset-password/{token}| password.reset  | Form reset contraseña    |
| POST   | reset-password       | password.update  | Actualizar contraseña    |

```
### Panel De Administracion
| Método   | URI                              | Nombre                          | Descripción                      |
|----------|----------------------------------|--------------------------------|----------------------------------|
| GET      | admin/panel                      | admin.panel                    | Dashboard admin                  |
| GET      | admin/panel/estadisticas         | admin.panel.estadisticas       | Ver estadísticas                 |
| GET      | admin/panel/descargas            | admin.panel.descargas          | Descargar contactos              |

```
```
### Instituciones
| Método   | URI                              | Nombre                          | Descripción                      |
|----------|----------------------------------|--------------------------------|----------------------------------|
| GET      | admin/instituciones              | admin.instituciones            | Listado de instituciones         |
| GET      | admin/instituciones/crear        | admin.instituciones.create     | Form crear institución           |
| POST     | admin/instituciones              | admin.instituciones.storeHogar | Guardar institución              |
| GET      | admin/instituciones/{id}/editar  | admin.instituciones.edit       | Editar institución               |
| PUT      | admin/instituciones/{id}         | admin.instituciones.update     | Actualizar institución           |
| DELETE   | admin/instituciones/{id}         | admin.instituciones.destroy    | Eliminar institución             |
```

```
### Noticias / Novedades

| Método   | URI                                  | Nombre                          | Descripción                      |
|----------|----------------------------------------|--------------------------------|----------------------------------|
| GET      | admin/noticias                        | admin.noticias                 | Listado de noticias              |
| GET      | admin/noticias/crear                  | admin.noticias.create          | Form crear noticia               |
| POST     | admin/noticias                        | admin.noticias.storeNoticia    | Guardar noticia                  |
| GET      | admin/noticias/{id}/editar            | admin.noticias.edit            | Editar noticia                   |
| PUT      | admin/noticias/{id}                   | admin.noticias.update          | Actualizar noticia               |
| DELETE   | admin/noticias/{id}                   | admin.noticias.destroy         | Eliminar noticia                 |
| POST     | admin/noticias/{id}/imagen            | admin.noticias.editarImagen    | Actualizar imagen                |

```
```
### Profesionales
| Método   | URI                                      | Nombre                              | Descripción                  |
|----------|--------------------------------------------|--------------------------------------|------------------------------|
| GET      | admin/profesionales                        | admin.profesionales                  | Listado de profesionales     |
| GET      | admin/profesionales/crear                  | admin.profesionales.create           | Form crear profesional       |
| POST     | admin/profesionales                        | admin.profesionales.store            | Guardar profesional          |
| GET      | admin/profesionales/{id}/editar            | admin.profesionales.edit             | Editar profesional           |
| PUT      | admin/profesionales/{id}                   | admin.profesionales.update           | Actualizar profesional       |
| DELETE   | admin/profesionales/{id}                   | admin.profesionales.destroy          | Eliminar profesional         |
| POST     | admin/profesionales/{id}/imagen            | admin.profesionales.editarImagen     | Actualizar imagen            |
```






## 👤 Autor

**Ingrid Ledesma** –Tecnica en desarrollo de aplicaciones informaticas – CISNE Consultorios

---

## 📄 Licencia

MIT © 2026 Cisne Consultorios

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
