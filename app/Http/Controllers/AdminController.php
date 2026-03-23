<?php

namespace App\Http\Controllers;

use App\Http\Requests\validacionNoticia;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Requests\validacionHogar;
use App\Models\noticiasModel;
use App\Models\profesionalesModel;
use App\Models\hogarModel;
use App\Models\Paciente_contacto;
use App\Models\ProfesionalEnvioCV;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Visita;
use App\Http\Requests\validacionEditarNoticia;
use App\Http\Requests\validacionProfesional;
use App\Models\direccionHogarModel;
use App\Models\imagesProfesionalesModel;
use App\Models\imagesNoticiasModel;
use App\Models\imagesHogarModel;
use App\Models\institucion_contacto;
use App\Models\redesHogarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PacienteExport;
use App\Exports\ProfesionalExport;
use App\Exports\InstitucionExport;
use function PHPUnit\Framework\isEmpty;


/**
 * @class AdminController
 * @brief Controlador principal del panel de administración.
 *
 * Este controlador gestiona todas las funcionalidades administrativas del sistema:
 *
 * - Gestión de profesionales (CRUD + imágenes)
 * - Gestión de noticias (CRUD + imágenes)
 * - Gestión de instituciones/hogares
 * - Estadísticas del sistema
 * - Exportación de datos (Excel)
 *
 * También aplica middlewares de autenticación y permisos
 * para restringir el acceso según el rol del usuario.
 *
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
 * @brief Constructor del controlador.
 *
 * Aplica middlewares de autenticación y autorización
 * para restringir el acceso a las distintas funcionalidades
 * según los permisos del usuario.
 *
 * @return void
 */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:crear profesional', [
            'only' => [
                'crearProfesional',
                'showFormCrearProfesional'
            ]
        ]);
        $this->middleware('can:editar profesional', [
            'only' => [
                'editarProfesional',
                'showFormEditarProfesional',
                'editarImagenProfesional'
            ]
        ]);
        $this->middleware('can:eliminar profesional', [
            'only' => [
                'eliminarProfesional'
            ]
        ]);


        //para noticias
        $this->middleware('can:crear noticia', [
            'only' => [
                'createNoticia',
                'showFormCreateNoticia'
            ]
        ]);

        $this->middleware('can:editar noticia', [
            'only' => [
                'showFormEditNoticia',
                'editNoticia',
                'editarImgsNoticias'
            ]
        ]);

        $this->middleware('can:eliminar noticia', [
            'only' => [
                'deleteNoticia'
            ]
        ]);

        $this->middleware('can:crear institucion', [
            'only' => [
                'createInstitucion',
                'showFormInstitucion'
            ]
        ]);


        $this->middleware('can:editar institucion', [
            'only' => [
                'editarInstitucion',
                'showInstitucion'
            ]
        ]);


        $this->middleware('can:eliminar Institucion', [
            'only' => [
                'deleteInstitucion'
            ]
        ]);
        $this->middleware('can:visualizar estadisticas', [
            'only' => [
                'viewVisits'
            ]
        ]);

    }

/**
 * @brief Muestra el panel principal de administración.
 *
 * @return \Illuminate\View\View Vista del panel admin
 */


    public function adminPanel()
    {
        return view('admin.panel');
    }


    /**
 * @brief Obtiene estadísticas generales del sistema.
 *
 * Retorna datos en formato JSON para ser consumidos
 * por gráficos o dashboards:
 * - Visitas del último mes
 * - Contactos
 * - Cantidad de profesionales, noticias e instituciones
 *
 * @return \Illuminate\Http\JsonResponse
 */


    public function estadisticasPanel()
    {
        return response()->json([
            'visitasUltimoMes' => Visita::where('fecha', '>=', now()->subMonth())->count(),
            'contactosUltimoMes' => Paciente_contacto::where('created_at', '>=', now()->subMonth())->count(),
            'profesionales' => ProfesionalesModel::count(),
            'noticias' => NoticiasModel::count(),
            'hogares' => HogarModel::count(),
        ]);
    }

/**
 * @brief Descarga contactos en formato Excel según el tipo.
 *
 * Permite exportar:
 * - Pacientes
 * - Profesionales
 * - Instituciones
 *
 * @param Request $request Contiene tipo, fecha desde y hasta
 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
 */




public function descargarContactos(Request $request)
{
    $tipo = $request->tipo;
    $desde = $request->desde;
    $hasta = $request->hasta;

    if ($tipo == 'pacientes') {
        return Excel::download(
            new PacienteExport($desde, $hasta),
            'pacientes.xlsx'
        );
    }

    if ($tipo == 'profesionales') {
        return Excel::download(
            new ProfesionalExport($desde, $hasta),
            'profesionales.xlsx'
        );
    }

    if ($tipo == 'hogares') {
        return Excel::download(
            new InstitucionExport(),
            'instituciones.xlsx'
        );
    }

    return back();
}

    /***************************Funcionalidad del controlador para profesionales ******************** */
    //traer profesionales cargados para pasarlos al blade


    /**
 * @brief Lista los profesionales con paginación.
 *
 * Incluye las imágenes asociadas.
 *
 * @return \Illuminate\View\View
 */
    public function profesionales()
    {
        $profesionales = ProfesionalesModel::with('imagenes')->paginate(10);

        return view('admin.profesionales.index', compact('profesionales'))
            ->with('i', (request()->input('page', 1) - 1) * $profesionales->perPage());
    }



    /* =====================================================
     * GUARDAR NUEVO
     * ===================================================== */


    /**
 * @brief Almacena un nuevo profesional.
 *
 * - Valida los datos del request
 * - Crea el registro en la base de datos
 * - Sube la imagen a Cloudinary (si existe)
 * - Guarda la referencia de la imagen
 *
 * @param validacionProfesional $request Datos validados
 * @return \Illuminate\Http\RedirectResponse
 */
    public function store(validacionProfesional $request)
    {

        $data = $request->validated();


        $prof = ProfesionalesModel::create([
            'nombre' => $request->nombre,
            'especialidad' => $request->especialidad,
            'matricula' => $request->matricula,

        ]);
     
        if ($request->hasFile('imagen')) {

         try {

    $upload = Cloudinary::upload(
        $request->file('imagen')->getRealPath(),
        ['folder' => 'profesionales']
    );

} catch (\Exception $e) {

    return back()->with('error', 'Error subiendo imagen: '.$e->getMessage());
}

            imagesProfesionalesModel::create([
                'profesional_id' => $prof->id,
                'url' => $upload->getSecurePath(),
                'public_id' => $upload->getPublicId()
            ]);
           // dd($request->hasFile('imagen'), $request->file('imagen'));
        }
        return redirect()
            ->route('admin.profesionales')
            ->with('success', 'Profesional creado correctamente');
    }



    /* =====================================================
     * GUARDAR EDICIÓN
     * ===================================================== */



    /**
 * @brief Actualiza los datos de un profesional existente.
 *
 * - Modifica datos básicos
 * - Si se envía nueva imagen:
 *   - Elimina la anterior (Cloudinary + BD)
 *   - Guarda la nueva
 *
 * @param Request $request Datos del formulario
 * @param int $id ID del profesional
 * @return \Illuminate\Http\RedirectResponse
 */
    public function updateProfesional(Request $request,$id)
    {
        $request->validate([
            'nombre' => 'required',
            'especialidad' => 'required',
            'matricula' => 'nullable',
            'descripcion' => 'nullable',
            'imagen' => 'nullable|image|max:2048'
        ]);
        $profesional = ProfesionalesModel::findOrFail($id);
        // Actualizar datos
        $profesional->update([
            'nombre' => $request->nombre,
            'especialidad' => $request->especialidad,
            'matricula' => $request->matricula,
        ]);

        // Reemplazo de imagen si se envía una nueva
        if ($request->hasFile('imagen')) {

            $imagenActual = imagesProfesionalesModel::where('profesional_id', $profesional->id)->first();

            if ($imagenActual) {
                Cloudinary::uploadApi()->destroy($imagenActual->public_id);
                $imagenActual->delete();
            }

            $upload = Cloudinary::upload(
                $request->file('imagen')->getRealPath(),
                ['folder' => 'profesionales']
            );

            imagesProfesionalesModel::create([
                'profesional_id' => $profesional->id,
                'url' => $upload->getSecurePath(),
                'public_id' => $upload->getPublicId()
            ]);
        }

        return redirect()->route('admin.profesionales')
            ->with('success', 'Profesional actualizado correctamente');
    }








    /****************************************** Editar profesional cargado *******************************************************/



    /**
 * @brief Muestra el formulario de edición de un profesional.
 *
 * @param int $id ID del profesional
 * @return \Illuminate\View\View
 */
  public function showFormEditarProfesional($id)
{
    //dd("entro al metodo show");
    $profesional = ProfesionalesModel::findOrFail($id);
    $imagen = $profesional->load('imagenes');

    return view('admin.profesionales.formEditarProfesional', compact('profesional','imagen'));
}


    /**
     * Edita la imagen del profesional (rostro) en BD y en Cloudinary.
     *
     * - Si llega una nueva imagen en el request, se reemplaza la anterior.
     * - Si no llega imagen, se mantiene la actual.
     *
     * @param int $id  ID del profesional
     * @param Request $request  Contiene la nueva imagen (si se cambió)
     * @return JsonResponse
     */



    /**
     * 1. Flujo de imágenes de profesionales

     ************************************* Crear profesional ********************************************

*Sube correctamente la(s) imagen(es) a Cloudinary bajo la carpeta profesionales.

*Guarda el url y public_id en la tabla imagen_profesional relacionada al profesional_id.

*Editar imagen del profesional (rostro):

*Busca la imagen actual del profesional.

*Si se sube una nueva, elimina la anterior de Cloudinary y BD.

*Sube la nueva y guarda correctamente.

*Si no se sube nada, mantiene la actual.

*Perfectamente coherente con el caso de uso: “cada profesional tiene una única foto de rostro”.
     */
/**
 * @brief Actualiza la imagen del profesional.
 *
 * - Elimina la imagen anterior
 * - Sube la nueva a Cloudinary
 * - Guarda la nueva referencia
 *
 * @param int $id ID del profesional
 * @param Request $request Contiene la imagen
 * @return \Illuminate\Http\RedirectResponse
 */

    public function editarImagenProfesional($id, Request $request)
    {
        $profesional = ProfesionalesModel::findOrFail($id);
        $archivo = $request->file('imagen');

        if (!$archivo) {
            return back()->with('info', 'No se cargó una nueva imagen');
        }

        $imagenActual = imagesProfesionalesModel::where('profesional_id', $id)->first();

        try {
            if ($imagenActual) {
                Cloudinary::uploadApi()->destroy($imagenActual->public_id);
                $imagenActual->delete();
            }

            $upload = Cloudinary::upload($archivo->getRealPath(), [
                'folder' => 'profesionales'
            ]);

            imagesProfesionalesModel::create([
                'profesional_id' => $id,
                'url' => $upload->getSecurePath(),
                'public_id' => $upload->getPublicId(),
            ]);

            return back()->with('success', 'Imagen actualizada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un problema al actualizar la imagen');
        }
    }

/**
 * @brief Actualiza la imagen del profesional.
 *
 * - Elimina la imagen anterior
 * - Sube la nueva a Cloudinary
 * - Guarda la nueva referencia
 *
 * @param int $id ID del profesional
 * @param Request $request Contiene la imagen
 * @return \Illuminate\Http\RedirectResponse
 */

    public function eliminarProfesional($id)
    {
        $profesional = ProfesionalesModel::findOrFail($id);

        foreach ($profesional->imagenes as $img) {
            if ($img->public_id) {
                Cloudinary::uploadApi()->destroy($img->public_id);
            }

            $img->delete();
        }

        $profesional->delete();

        return back()
            ->with('success_titulo', 'Eliminado')
            ->with('success_detalle', 'El profesional fue eliminado con éxito');
    }




    /************************ funcionalidad del controlador para noticias ********************************** */
    /***
     *  2. Flujo de imágenes de noticias

✔ Crear noticia:

Exige una imagen obligatoria.

La sube a la carpeta noticias.

Crea la noticia y asocia una sola imagen.

✔ Editar noticia:

Actualiza datos textuales.

Si hay nueva imagen → elimina la anterior (Cloudinary + BD) y sube la nueva.

Mantiene una única imagen por noticia.

✔ Eliminar noticia:

Borra la imagen de Cloudinary y el registro asociado antes de eliminar la noticia.

 Perfectamente coherente con tu requerimiento: “solo una imagen por noticia”.

     */


    //traer noticias cargados para pasarlos al blade

    /**
 * @brief Lista las noticias con paginación.
 *
 * Incluye su imagen asociada.
 *
 * @return \Illuminate\View\View
 */
    public function noticias()
    {
        $noticias = NoticiasModel::with('imagenesNoticias')->paginate(10);

        return view('admin.noticias.index', compact('noticias'))
            ->with('i', (request()->input('page', 1) - 1) * $noticias->perPage());
    }




/**
 * @brief Crea una nueva noticia con imagen obligatoria.
 *
 * - Valida datos
 * - Guarda noticia
 * - Sube imagen a Cloudinary
 * - Registra imagen en BD
 *
 * @param Request $request Datos del formulario
 * @return \Illuminate\Http\RedirectResponse
 */


    public function storeNoticia(Request $request)
    {
        // Validaciones
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|exists:categorias_news,id',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        //creamos noticia en tabla noticia
        $noticia = new NoticiasModel();
        $noticia->titulo = $request->titulo;
        $noticia->categoria_id = $request->categoria;
        $noticia->descripcion = $request->descripcion;
        $noticia->save();
        // Cargar imagen en Cloudinary
        $resultado = Cloudinary::upload($request->file('imagen')->getRealPath(), [
            'folder' => 'noticias'
        ]);

        // Obtener datos de la imagen
        $url = $resultado->getSecurePath();
        $publicId = $resultado->getPublicId();

        // Guardar en BD imagen_noticia

        $imgnoticia= new imagesNoticiasModel();
        $imgnoticia->noticia_id = $noticia->id;

        $imgnoticia->url = $url;
        $imgnoticia->public_id = $publicId;
        $imgnoticia->save();

        // Redirigir con mensaje
        return redirect()->route('admin.noticias')
            ->with('success', 'Noticia creada correctamente');

    }

    

    protected function showFormCreateNoticia(){
        $categorias = NoticiasModel::obtenerCategorias();
        return view("admin.noticias.formCrearNoticia", compact("categorias"));
}

    protected function showFormEditNoticia($id){
        $categorias = NoticiasModel::obtenerCategorias();
        $noticia = NoticiasModel::showNoticiasId($id);
        return view("admin.noticias.formEditarNoticia", compact("noticia", "categorias"));
}

/**
 * @brief Actualiza una noticia existente.
 *
 * - Modifica datos textuales
 * - Si hay nueva imagen:
 *   - Elimina la anterior
 *   - Guarda la nueva
 *
 * @param validacionNoticia $request Datos validados
 * @param int $id ID de la noticia
 */

    protected function editNoticia(validacionNOticia $request, $id)
    {
        $noticia = NoticiasModel::findOrFail($id);
        
        //    dd("ENTRÉ AL UPDATE");
        // Validación (la imagen NO es obligatoria)
      

        /** ------------------ ACTUALIZAR CAMPOS DE LA NOTICIA ------------------ **/
        $noticia->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria,
        ]);

        /** ------------------ IMAGEN ------------------ **/

        // Buscar imagen actual
        $imagen = imagesNoticiasModel::where('noticia_id', $noticia->id)->first();

        // ¿Se sube nueva imagen?
        if ($request->hasFile('imagen')) {

            // Si existe imagen previa → la elimino de Cloudinary
            if ($imagen && $imagen->public_id) {
                try {
                    Cloudinary::uploadApi()->destroy($imagen->public_id);
                } catch (\Exception $e) {
                    Log::error("Error al eliminar imagen anterior: " . $e->getMessage());
                }
            }

            // Subir nueva
            $upload = Cloudinary::upload(
                $request->file('imagen')->getRealPath(),
                ['folder' => 'noticias']
            );

            $url = $upload->getSecurePath();
            $publicId = $upload->getPublicId();

            // Guardar en tabla imagen_noticias
            if ($imagen) {
                // Actualizar la existente
                $imagen->update([
                    'url' => $url,
                    'public_id' => $publicId,
                ]);
            } else {
                // Crear si no existe
                imagesNoticiasModel::create([
                    'noticia_id' => $noticia->id,
                    'url' => $url,
                    'public_id' => $publicId,
                ]);
            }
        }

        return redirect()->route('admin.noticias')
            ->with('success', 'Noticia actualizada correctamente');
    }


/**
 * @brief Elimina una noticia y su imagen asociada.
 *
 * @param int $id ID de la noticia
 * @return \Illuminate\Http\RedirectResponse
 */


    protected function deleteNoticia($id)
    {
        // 1) Buscar la noticia
        $noticia = NoticiasModel::findOrFail($id);

        // 2) Buscar la imagen asociada
        $imagen = imagesNoticiasModel::where('noticia_id', $id)->first();

        // 3) Si existe imagen: eliminar de Cloudinary y de la BD
        if ($imagen) {
            try {
                Cloudinary::uploadApi()->destroy($imagen->public_id);
            } catch (\Exception $e) {
                Log::error("Error eliminando imagen en Cloudinary: " . $e->getMessage());
            }

            $imagen->delete();
        }

        // 4) Eliminar noticia
        $noticia->delete();

        return back()->with('success', 'La noticia fue eliminada correctamente.');

    }



    /*************************************************************************************************
     */


    /**
 * @brief Lista instituciones (hogares).
 *
 * @return \Illuminate\View\View
 */

    public function instituciones()
    {
        $hogares = HogarModel::with('imagenes')->paginate(10);

        return view('admin.hogares.index', compact('hogares'))
            ->with('i', (request()->input('page', 1) - 1) * $hogares->perPage());
    }

/**
 * @brief Muestra el formulario de creación de institución.
 *
 * @return \Illuminate\View\View
 */

    public function createHogar()
    {

        return view('admin.hogares.formNuevoHogar');
    }



    public function editShowHogar($id)
    {
        $hogar = HogarModel::FindOrFail($id);
        return view("admin.hogares.formEditarHogar", compact("hogar"));
    }
/**
 * @brief Actualiza una institución existente.
 *
 * - Actualiza datos generales
 * - Actualiza redes y dirección
 * - Maneja imagen (reemplazo opcional)
 *
 * @param int $id ID del hogar
 * @param Request $request Datos del formulario
 * @return \Illuminate\Http\RedirectResponse
 */

    public function updateHogar($id,Request $request){

        $hogar = HogarModel::findOrFail($id);
        // Validación (la imagen NO es obligatoria)
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'facebook'=>'required|string',
            'instagram' => 'required|string',
            'whatsapp' => 'required|string',
            'provincia' => 'required|string',
            'localidad' => 'required|string',
            'ciudad' => 'required|string',
            'calleYAltura' => 'required|string',

        ]);

        /** ------------------ ACTUALIZAR CAMPOS DEL HOGAR------------------ **/
        $hogar->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'redes_id' => $hogar->redes_id,
            'direccion_id' => $hogar->direccion_id
        ]);


        $redes= redesHogarModel::findOrFail($hogar->redes_id);

        $redes->update([
          'instagram'=>$request->instagram,
          'facebook'=>$request->facebook,
          'whatsapp'=>$request->whatsapp
        ]);

        $direccion = direccionHogarModel::findOrFail($hogar->direccion_id);

        $direccion->update([
            'provincia'=>$request->provincia,
            'localidad'=>$request->localidad,
            'ciudad'=>$request->ciudad,
            'calleYAltura'=>$request->calleYAltura
        ]);

        //actualizar imagen cargada al hogar

        // Buscar imagen actual


        $imagen = imagesHogarModel::where('hogar_id', $hogar->id)->first();


        // ¿Se sube nueva imagen?
        if ($request->hasFile('imagen')) {

            // Si existe imagen previa → la elimino de Cloudinary
            if ($imagen && $imagen->public_id) {
                try {
                    Cloudinary::uploadApi()->destroy($imagen->public_id);
                } catch (\Exception $e) {
                    Log::error("Error al eliminar imagen anterior: " . $e->getMessage());
                }
            }

            // Subir nueva
            $upload = Cloudinary::upload(
                $request->file('imagen')->getRealPath(),
                ['folder' => 'instituciones']
            );

            $url = $upload->getSecurePath();
            $publicId = $upload->getPublicId();

            // Guardar en tabla imagen_noticias
            if ($imagen) {
                // Actualizar la existente
                $imagen->update([
                    'url' => $url,
                    'public_id' => $publicId,
                ]);
            } else {
                // Crear si no existe
                imagesHogarModel::create([
                    'hogar_id' => $hogar->id,
                    'url' => $url,
                    'public_id' => $publicId,
                ]);
            }
        }

        return redirect()->route('admin.instituciones')
            ->with('success', 'Instituciones actualizada correctamente');

       // return back()->with('success', 'Instituciones actualizada correctamente');
    }










    /************************************************************* */
    /**
 * @brief Almacena una nueva institución.
 *
 * - Crea redes sociales
 * - Crea dirección
 * - Crea el hogar
 * - Sube imagen (opcional)
 *
 * @param Request $request Datos del formulario
 * @return \Illuminate\Http\RedirectResponse
 */
    public function storeHogar(Request $request)


    {
       

        // Crear redes
        $Redes = redesHogarModel::crearRedes(
            $request->instagram,
            $request->facebook,
            $request->whatsapp
        );

        // Crear dirección
        $Direccion = direccionHogarModel::crearDireccion(
            $request->provincia,
            $request->localidad,
            $request->ciudad,
            $request->calleYAltura
        );

        // Crear hogar
        $hogar = HogarModel::crearHogar(
            $request->nombre,
            $request->descripcion,
            $Redes->id,
            $Direccion->id

        );

        // Inicializar variables necesarias
        $url = null;
        $publicId = null;
        $mensajes = null;

        // Si hay imagen, subirla
        if ($request->hasFile('imagen')) {

            try {
                $resultado = Cloudinary::upload(
                    $request->file('imagen')->getRealPath(),
                    ['folder' => 'instituciones']
                );

                $url = $resultado->getSecurePath();
                $publicId = $resultado->getPublicId();
            } catch (\Exception $e) {

                $mensajes = [
                    'titulo' => '¡Error!',
                    'detalle' => 'Ha sucedido un error en la subida de la imagen, intente nuevamente.'
                ];

                return redirect()
                    ->back()
                    ->with('mensaje_error', $mensajes)
                    ->withInput();
            }
        }

        // Guardar imagen en BD
        try {

            $imghogar = new imagesHogarModel();
            $imghogar->hogar_id = $hogar->id;
            $imghogar->url = $url;
            $imghogar->public_id = $publicId;
            $imghogar->save();
        } catch (\Exception $e) {

            $mensajes = [
                'titulo' => '¡Error!',
                'detalle' => 'Ha sucedido un error en la carga de la imagen en la BD.'
            ];

            return redirect()
                ->back()
                ->with('mensaje_error', $mensajes)
                ->withInput();
        }

        // Si todo salió bien
        if ($Redes && $Direccion && $hogar) {

            return redirect()
                ->route('admin.instituciones')
                ->with('success', 'Institucion publicada correctamente');
        }

        // Si algo falló en la creación
        $mensajes = [
            'titulo' => '¡Error!',
            'detalle' => 'Ha sucedido un error al publicar la institucion, inténtelo nuevamente.'
        ];

        return redirect('admin/instituciones')
            ->with('error', $mensajes)
            ->withInput();
    }


    /**
 * @brief Elimina una institución y sus relaciones.
 *
 * - Imágenes
 * - Dirección
 * - Redes sociales
 *
 * @param int $id ID del hogar
 * @return \Illuminate\Http\RedirectResponse
 */
    public function eliminarHogar($id)
    {
        try {
            // Buscar el hogar con todas las relaciones
            $hogar = HogarModel::with(['imagenes', 'direccion', 'redes'])->findOrFail($id);

            /* ------------------------------------------------------
           1) ELIMINAR IMÁGENES
        ------------------------------------------------------ */
            if ($hogar->imagenes && $hogar->imagenes->count() > 0) {

                foreach ($hogar->imagenes as $img) {

                    /* Si usás Cloudinary y guardás el public_id, eliminá así:

                \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::destroy($img->public_id);

                */

                    // Eliminar registro en la base
                    $img->delete();
                }
            }

            /* ------------------------------------------------------
           2) ELIMINAR DIRECCIÓN (si existe)
        ------------------------------------------------------ */
            if ($hogar->direccion) {
                $hogar->direccion->delete();
            }

            /* ------------------------------------------------------
           3) ELIMINAR REDES (si existen)
        ------------------------------------------------------ */
            if ($hogar->redes) {
                $hogar->redes->delete();
            }

            /* ------------------------------------------------------
           4) ELIMINAR EL HOGAR
        ------------------------------------------------------ */
            $hogar->delete();

            return redirect()
                ->route('admin.instituciones')
                ->with('success', 'La institución fue eliminada correctamente.');
        } catch (\Exception $e) {

            return redirect()
                ->route('admin.instituciones')
                ->with('error', 'Error al eliminar institución: ' . $e->getMessage());
        }
    }
}

