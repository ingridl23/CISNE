<?php

namespace App\Http\Controllers;

use App\Http\Requests\validacionNoticia;
use App\Models\noticiasModel;
use App\Models\ProfesionalesModel;
use App\Models\hogarModel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use App\Http\Requests\validacionEditarNoticia;
use App\Http\Requests\validacionProfesional;
use App\Models\imagesProfesionalesModel;
use App\Models\imagesNoticiasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    }

    public function adminPanel()
    {
        return view('admin.layouts', [
            'totalProfesionales' => ProfesionalesModel::count(),
            'totalNoticias'      => noticiasModel::count(),
            'totalInstituciones'=> hogarModel::count()
        ]);
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
        $noticias = noticiasModel::with('imagenesNoticias')->paginate(10);

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
        $categorias = noticiasModel::obtenerCategorias();
        return view("admin.noticias.formCrearNoticia", compact("categorias"));
}

    protected function showFormEditNoticia($id){
        $categorias = noticiasModel::obtenerCategorias();
        $noticia = noticiasModel::showNoticiasId($id);
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
        $noticia = noticiasModel::findOrFail($id);

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
        $hogares = hogarModel::with('HogaresImagenes')->paginate(10);

        return view('admin.hogares.index', compact('hogares'))
            ->with('i', (request()->input('page', 1) - 1) * $hogares->perPage());
    }







/************************************************************* */
    protected function storeHogar(Request $request){
        // Validaciones
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'redes_id' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'direccion_id'=> 'required'
        ]);

        //creamos el hogar en tabla hogar_mayor
        $hogar = new hogarModel();
        $hogar->titulo = $request->titulo;
        $hogar->descripcion = $request->descripcion;
        $hogar->redes_id (nose como guardar)
        $hogar->save();
        // Cargar imagen en Cloudinary
        $resultado = Cloudinary::upload($request->file('imagen')->getRealPath(), [
            'folder' => 'instituciones'
        ]);

        // Obtener datos de la imagen
        $url = $resultado->getSecurePath();
        $publicId = $resultado->getPublicId();

        // Guardar en BD imagen_noticia

        $imghogar = new imagesHogarModel();
        $imghogar->hogar_id = $hogar->id;

        $imghogar->url = $url;
        $imghogar->public_id = $publicId;
        $imghogar->save();


        //guardar en bd datos de redes sociales

        return redirect()
            ->route('admin.instituciones')
            ->with('success', 'Institucion publicada correctamente');
    }



    }
    protected function eliminarInstitucion() {}
}
