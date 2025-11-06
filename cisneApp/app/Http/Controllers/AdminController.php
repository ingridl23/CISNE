<?php

namespace App\Http\Controllers;

use App\Http\Requests\validacionNoticia;
use App\Models\noticiasModel;
use App\Models\ProfesionalesModel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use App\Http\Requests\validacionEditarNoticia;
use App\Http\Requests\validacionProfesional;
use App\Models\imagesProfesionalesModel;
use App\Models\imagesNoticiasModel;
use Illuminate\Http\Request;

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
    }

    public function adminPanel()
    {
        return view('admin.layouts', [
            'totalProfesionales' => ProfesionalesModel::count(),
            'totalNoticias'      => noticiasModel::count(),
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

    public function showFormCrearProfesional()
    {
        return view('admin.profesionales.create');
    }


    public function crearProfesional(validacionProfesional $request)
    {
        $data = $request->validated();

        $profesional = ProfesionalesModel::create([
            'nombre'       => $data['nombre'],
            'especialidad' => $data['especialidad'],
            'matricula'    => $data['matricula'],
        ]);

        // Cargar imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {

                $upload = Cloudinary::upload($imagen->getRealPath(), [
                    'folder' => 'profesionales',
                    'quality' => '100'
                ]);

                $profesional->imagenes()->create([
                    'url' => $upload->getSecurePath(),
                    'public_id' => $upload->getPublicId()
                ]);
            }
        }

        return redirect()->route('profesionales')->with('success', [
            'titulo' => '¡Creado!',
            'detalle' => 'Profesional agregado con éxito'
        ]);
    }





/****************************************** Editar profesional cargado *******************************************************/

    public function showFormEditarProfesional(ProfesionalesModel $profesional)
    {
        $imagenes = imagesProfesionalesModel::where('profesional_id', $profesional->id)->get();

        return view("admin.profesionales.formEditarProfesional", compact('profesional', 'imagenes'));
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

Sube correctamente la(s) imagen(es) a Cloudinary bajo la carpeta profesionales.

Guarda el url y public_id en la tabla imagen_profesional relacionada al profesional_id.

Editar imagen del profesional (rostro):

Busca la imagen actual del profesional.

Si se sube una nueva, elimina la anterior de Cloudinary y BD.

Sube la nueva y guarda correctamente.

Si no se sube nada, mantiene la actual.

Perfectamente coherente con el caso de uso: “cada profesional tiene una única foto de rostro”.
     */
    public function editarImagenProfesional($id, Request $request)
    {
        $profesional = ProfesionalesModel::findOrFail($id);

        $archivo = $request->file('imagen');

        if (!$archivo) {
            return back()->with('info', [
                'titulo' => 'Sin cambios',
                'detalle' => 'No se cargó una nueva imagen'
            ]);
        }

        // Imagen anterior
        $imagenActual = imagesProfesionalesModel::where('profesional_id', $id)->first();

        try {
            // Eliminar si existe
            if ($imagenActual) {
                Cloudinary::uploadApi()->destroy($imagenActual->public_id);
                $imagenActual->delete();
            }

            // Subir nueva
            $upload = Cloudinary::upload($archivo->getRealPath(), [
                'folder' => 'profesionales'
            ]);

            imagesProfesionalesModel::create([
                'profesional_id' => $id,
                'url' => $upload->getSecurePath(),
                'public_id' => $upload->getPublicId(),
            ]);

            return back()->with('success', [
                'titulo' => 'Éxito',
                'detalle' => 'Imagen actualizada correctamente'
            ]);
        } catch (\Exception $e) {

            return back()->with('error', [
                'titulo' => 'Error',
                'detalle' => 'Hubo un problema al actualizar la imagen'
            ]);
        }
    }




    public function eliminarProfesional($id)
    {
        $profesional = ProfesionalesModel::findOrFail($id);

        // Eliminar imágenes asociadas
        foreach ($profesional->imagenes as $img) {
            Cloudinary::uploadApi()->destroy($img->public_id);
            $img->delete();
        }

        $profesional->delete();

        return back()->with('success', [
            'titulo' => 'Eliminado',
            'detalle' => 'El profesional fue eliminado con éxito'
        ]);
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


    protected function createNoticia(validacionNoticia $request)
    {
        if (!$request->hasFile('imagen')) {
            return redirect('/noticias')->with('error', [
                'titulo' => '¡Error!',
                'detalle' => 'Debe cargar una imagen para la noticia.'
            ]);
        }

        try {
            // 1 Subo la imagen
            $imagen = $request->file('imagen');
            $uploadedFileUrl = Cloudinary::upload($imagen->getRealPath(), [
                'folder' => 'noticias',
                'quality' => 'auto:best'
            ]);

            // 2 Creo la noticia
            $noticia = noticiasModel::createNoticia($request);

            // 3 Asocio la imagen
            $noticia->imagenesNoticias()->create([
                'url' => $uploadedFileUrl->getSecurePath(),
                'public_id' => $uploadedFileUrl->getPublicId(),
            ]);

            return redirect('/noticias')->with('success', [
                'titulo' => '¡Creado!',
                'detalle' => 'Noticia creada con éxito.'
            ]);
        } catch (\Exception $e) {
            return redirect('/noticias')->with('error', [
                'titulo' => '¡Error!',
                'detalle' => 'No se pudo crear la noticia. Intente nuevamente.'
            ]);
        }
    }


    protected function showFormCreateNoticia(){
        $categorias = $this->obtenerCategorias();
        return view("admin.noticias.formCrearNoticia", compact("categorias"));
}

    protected function showFormEditNoticia($id){
        $categorias = $this->obtenerCategorias();
        $noticia = noticiasModel::showNoticia($id);
        return view("admin.noticias.formEditarNoticia", compact("noticia", "categorias"));
}





    protected function editNoticia($id, validacionNoticia $request)
    {
        $noticia = noticiasModel::find($id);
        if (!$noticia) {
            return redirect('/noticias')->with('error', [
                'titulo' => 'Error',
                'detalle' => 'No se encontró la noticia.'
            ]);
        }

        try {
            $noticia->update([
                'titulo' => $request->input('titulo'),
                'descripcion' => nl2br($request->input('descripcion')),
                'categoria' => $request->input('categoria'),
            ]);

            // Si se subió una nueva imagen, reemplazo la anterior
            if ($request->hasFile('imagen')) {
                $imagenActual = $noticia->imagenesNoticias;
                if ($imagenActual) {
                    Cloudinary::uploadApi()->destroy($imagenActual->public_id);
                    $imagenActual->delete();
                }

                $uploadedFileUrl = Cloudinary::upload($request->file('imagen')->getRealPath(), [
                    'folder' => 'noticias',
                    'quality' => 'auto:best'
                ]);

                $noticia->imagenesNoticias()->create([
                    'url' => $uploadedFileUrl->getSecurePath(),
                    'public_id' => $uploadedFileUrl->getPublicId(),
                ]);
            }

            return redirect('/noticias')->with('success', [
                'titulo' => '¡Editado!',
                'detalle' => 'Noticia editada con éxito.'
            ]);
        } catch (\Exception $e) {
            return redirect('/noticias')->with('error', [
                'titulo' => '¡Error!',
                'detalle' => 'Ocurrió un problema al editar la noticia.'
            ]);
        }
    }


    protected function deleteNoticia($id)
    {
        $noticia = noticiasModel::find($id);
        if (!$noticia) {
            return redirect('/noticias')->with('error', [
                'titulo' => '¡Error!',
                'detalle' => 'No se encontró la noticia.'
            ]);
        }

        try {
            $imagen = $noticia->imagenesNoticias;
            if ($imagen) {
                Cloudinary::uploadApi()->destroy($imagen->public_id);
                $imagen->delete();
            }

            $noticia->delete();

            return redirect('/noticias')->with('success', [
                'titulo' => '¡Eliminado!',
                'detalle' => 'La noticia fue eliminada con éxito.'
            ]);
        } catch (\Exception $e) {
            return redirect('/noticias')->with('error', [
                'titulo' => '¡Error!',
                'detalle' => 'Ocurrió un problema al eliminar la noticia.'
            ]);
        }
    }

    /**
     * Edita la imagen principal de una noticia en BD y en Cloudinary.
     *
     * - Si llega una nueva imagen, reemplaza la existente.
     * - Si no llega imagen nueva, mantiene la actual.
     *
     * @param int $id  ID de la noticia
     * @param Request $request  Contiene la nueva imagen (si se cambió)
     * @return JsonResponse
     */
    public function editarImagenNoticia($id, Request $request)
    {
        $noticia = NoticiasModel::find($id);
        if (!$noticia) {
            return response()->json([
                'message' => [
                    'titulo' => 'Error',
                    'detalle' => 'Noticia no encontrada.'
                ],
                'status' => 'error'
            ], 404);
        }

        // Buscar imagen actual asociada a la noticia
        $imagenExistente = imagesNoticiasModel::where('noticia_id', $id)->first();

        // Verificar si llega una nueva imagen en el request
        $nuevaImagen = $request->file('imagen');

        if ($nuevaImagen) {
            try {
                // Si ya existe una imagen, eliminarla de Cloudinary y de la BD
                if ($imagenExistente) {
                    Cloudinary::uploadApi()->destroy($imagenExistente->public_id);
                    imagesNoticiasModel::eliminarImagen($imagenExistente);
                }

                // Subir la nueva imagen a Cloudinary
                $upload = Cloudinary::upload($nuevaImagen->getRealPath(), [
                    'folder' => 'noticias'
                ]);

                // Guardar la nueva imagen en BD
                imagesNoticiasModel::create([
                    'noticia_id' => $id,
                    'url' => $upload->getSecurePath(),
                    'public_id' => $upload->getPublicId(),
                ]);

                return response()->json([
                    'redirect' => "/noticias/formEditarNoticia/{$id}",
                    'message' => [
                        'titulo' => 'Éxito',
                        'detalle' => 'La imagen de la noticia fue actualizada correctamente.'
                    ],
                    'status' => 'success'
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => [
                        'titulo' => 'Error',
                        'detalle' => 'Ocurrió un error al actualizar la imagen: ' . $e->getMessage()
                    ],
                    'status' => 'error'
                ], 500);
            }
        } else {
            // No se envió nueva imagen
            return response()->json([
                'message' => [
                    'titulo' => 'Sin cambios',
                    'detalle' => 'No se cargó una nueva imagen, se mantiene la actual.'
                ],
                'status' => 'info'
            ], 200);
        }
    }
}

