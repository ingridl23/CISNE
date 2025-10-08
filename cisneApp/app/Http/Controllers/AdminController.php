<?php

namespace App\Http\Controllers;

use App\Http\Requests\validacionNoticia;
use App\Models\noticiasModel;
use App\Models\ProfesionalesModel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use App\Http\Requests\validacionEditarNoticia;
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

function adminPanel(){
   return view('admin.panel');
}


/***************************Funcionalidad del controlador para profesioales ******************** */
    //traer profesionales cargados para pasarlos al blade
    public function profesionales()
    {
        $profesionales = ProfesionalesModel::paginate(10);
        return view('layouts.templateHome', compact('profesionales'))
            ->with('i', (request()->input('page', 1) - 1) * $profesionales->perPage());


    }

    public function showFormCrearProfesional()
    {
        $profesionales = ProfesionalesModel::all();
        return view('admin.emprendedores.formNuevoProfesional', compact('profesionales'));
    }


    public function crearProfesional(validacionEmprendimiento $request)
    {
        $data = $request->validated();



        $profesional = ProfesionalesModel::create([
            'nombre' => $data['nombre'],
            'profesion' => $data['categoria'],
            'descripcion' => $data['descripcion'],
            'matricula' => $matricula,

        ]);
    }

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                //try {
                $uploadedFileUrl = Cloudinary::upload($imagen->getRealPath(), [
                    'folder' => 'emprendedores',
                    'quality' => '100'
                ]);
                $profesionales->imagenes()->create([
                    'url' => $uploadedFileUrl->getSecurePath(),
                    'public_id' => $uploadedFileUrl->getPublicId(),
                ]);
                /* } catch (\Exception $e) {
                    $mensajes = [
                        'titulo' => '¡Error!',
                        'detalle' => 'Ha sucedido un error en la carga de las imagenes, aca, intente nuevamente.'
                    ];
                    return redirect('/emprendedores')->with('error', $mensajes);
                }*/
            }
        }

        if ($emprendimiento) {
            $mensajes = [
                'titulo' => '¡Creado!',
                'detalle' => 'Profesional agregado con éxito.'
            ];
            return redirect('/profesionales')->with('success', $mensajes);
        } else {
            $mensajes = [
                'titulo' => 'Error!',
                'detalle' => 'Ha sucedido un error al agregar el profesional,inténtelo nuevamente,corrobore los datos ingresados.'
            ];
            return redirect('/emprendedores')->with('success', $mensajes);
        }
    }



    /************************ funcionalidad del controlador para noticias ********************************** */
    protected function createNoticia(validacionNoticia $request){
        if ($request->hasFile('imagen')) {
            try {
                $imagen = $request->file('imagen');
                $uploadedFileUrl = Cloudinary::upload($imagen->getRealPath(), [
                    'quality' => 'auto:best',
                    'folder' => 'noticias'
                ]);
                $path = $uploadedFileUrl->getSecurePath();
                $imagen_public_id =  $uploadedFileUrl->getPublicId();
            } catch (\Exception $e) {
                $mensajes = [
                    'titulo' => '¡Error!',
                    'detalle' => 'Ha sucedido un error al crear la noticia, intente nuevamente.'
                ];
                return redirect('/noticias')->with('error', $mensajes);
            }
        } else {
            $mensajes = [
                'titulo' => '¡Error!',
                'detalle' => 'Ha sucedido un error en la carga de la imagen, intente nuevamente..'
            ];
            return redirect('/noticias')->with('error', $mensajes);
        }
        //nl2br Salto de linea
        $descripcion = nl2br($request->descripcion);
        $creado = noticiasModel::createNoticia($request, $path, $imagen_public_id);
        if ($creado && $creado != null) {
            $mensajes = [
                'titulo' => 'Creado!',
                'detalle' => 'Noticia creada con éxito.'
            ];
            return redirect('/noticias')->with('success', $mensajes);
        } else {
            $mensajes = [
                'titulo' => 'Error!',
                'detalle' => 'Ha sucedido un error al crear la noticia, inténtelo nuevamente.'
            ];
            return redirect('/noticias')->with('error', $mensajes);
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

    protected  function EditNoticia($id, validacionEditarNoticia $request){
        $noticia = noticiasModel::find($id);
        if ($noticia != null) {
            $noticia->titulo = $request->input('titulo');
            $noticia->descripcion = $request->input('descripcion');
            $noticia->categoria = $request->input('categoria');
            noticiasModel::editNoticia($noticia);
            $mensajes = [
                'titulo' => '¡Editado!',
                'detalle' => 'Noticia editada con éxito.'
            ];

            return redirect('/noticias')->with('success', $mensajes);
        } else {
            $mensajes = [
                'titulo' => '¡Error!',
                'detalle' => 'Ha sucedido un error al editar la noticia, inténtelo nuevamente.'
            ];
            return redirect('/noticias')->with('error', $mensajes);
        }


}


 protected function deleteNoticia($id){
        $noticia = noticiasModel::find($id);
        if ($noticia != null) {
            try {
                Cloudinary::uploadApi()->destroy($noticia->imagen_public_id);
            } catch (\Exception $e) {
                $mensajes = [
                    'titulo' => '¡Error!',
                    'detalle' => 'Ha sucedido un error al eliminar la imagen, intente nuevamente.'
                ];
                return redirect('/noticias')->with('error', $mensajes);
            }
            $eliminado = noticiasModel::deleteNoticia($noticia);
            if ($eliminado && $eliminado != null) {
                $mensajes = [
                    'titulo' => '¡Eliminado!',
                    'detalle' => 'La noticia ha sido eliminada con éxito.'
                ];
                return redirect('/noticias')->with('success', $mensajes);
            } else {
                $mensajes = [
                    'titulo' => '¡Error!',
                    'detalle' => 'Ha sucedido un error al eliminar el emprendimiento, intente nuevamente.'
                ];
                return redirect('/noticias')->with('error', $mensajes);
            }
        } else {
            $mensajes = [
                'titulo' => '¡Error!',
                'detalle' => 'No se ha encontrado la noticia que se desea eliminar.'
            ];
            return redirect('/noticias')->with('error', $mensajes);
        }
    }




