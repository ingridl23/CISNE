<?php

namespace App\Http\Controllers;

use App\Http\Requests\validacionNoticia;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Requests\validacionHogar;
use App\Models\noticiasModel;
use App\Models\ProfesionalesModel;
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

class AdminController extends Controller
{
    //
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



    public function adminPanel()
    {
        return view('admin.panel');
    }


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

    public function profesionales()
    {
        $profesionales = ProfesionalesModel::with('imagenes')->paginate(10);

        return view('admin.profesionales.index', compact('profesionales'))
            ->with('i', (request()->input('page', 1) - 1) * $profesionales->perPage());
    }



    /* =====================================================
     * GUARDAR NUEVO
     * ===================================================== */
    public function store(validacionProfesional $request)
    {

        $data = $request->validated();


        $prof = ProfesionalesModel::create([
            'nombre' => $request->nombre,
            'especialidad' => $request->especialidad,
            'matricula' => $request->matricula,

        ]);
        if ($request->hasFile('imagen')) {

            $upload = Cloudinary::upload(
                $request->file('imagen')->getRealPath(),
                ['folder' => 'profesionales']
            );

            imagesProfesionalesModel::create([
                'profesional_id' => $prof->id,
                'url' => $upload->getSecurePath(),
                'public_id' => $upload->getPublicId()
            ]);
        }

        return redirect()
            ->route('admin.profesionales')
            ->with('success', 'Profesional creado correctamente');
    }



    /* =====================================================
     * GUARDAR EDICIÓN
     * ===================================================== */
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

    /*
    public function showFormEditarProfesional($id)
    {
        $profesional = ProfesionalesModel::with('imagenes')->findOrFail($id);
        $imagenes = $profesional->imagenes; // colección (vacía si no hay)
        return view('admin.profesionales.formEditarProfesional', compact('profesional', 'imagenes'));
    }
*/


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

Sube correctamente la(s) imagen(es) a Cloudinary bajo la carpeta profesionales.

Guarda el url y public_id en la tabla imagen_profesional relacionada al profesional_id.

Editar imagen del profesional (rostro):

Busca la imagen actual del profesional.

Si se sube una nueva, elimina la anterior de Cloudinary y BD.

Sube la nueva y guarda correctamente.

Si no se sube nada, mantiene la actual.

Perfectamente coherente con el caso de uso: “cada profesional tiene una única foto de rostro”.
     */

/*
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
    public function noticias()
    {
        $noticias = NoticiasModel::with('imagenesNoticias')->paginate(10);

        return view('admin.noticias.index', compact('noticias'))
            ->with('i', (request()->input('page', 1) - 1) * $noticias->perPage());
    }







    public function storeNoticia(Request $request)
    {
        // Validaciones
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        //creamos noticia en tabla noticia
        $noticia = new NoticiasModel();
        $noticia->titulo = $request->titulo;
        $noticia->categoria = $request->categoria;
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




    protected function editNoticia(validacionNoticia $request, $id)
    {
        $noticia = NoticiasModel::findOrFail($id);
        // Validación (la imagen NO es obligatoria)
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        /** ------------------ ACTUALIZAR CAMPOS DE LA NOTICIA ------------------ **/
        $noticia->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
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

    public function instituciones()
    {
        $hogares = HogarModel::with('imagenes')->paginate(10);

        return view('admin.hogares.index', compact('hogares'))
            ->with('i', (request()->input('page', 1) - 1) * $hogares->perPage());
    }



    public function createHogar()
    {

        return view('admin.hogares.formNuevoHogar');
    }

    public function editShowHogar($id)
    {
        $hogar = HogarModel::FindOrFail($id);
        return view("admin.hogares.formEditarHogar", compact("hogar"));
    }


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
    public function storeHogar(Request $request)


    {
       // dd("ENTRÓ AL MÉTODO");

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

