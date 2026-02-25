<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class validacionNoticia  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function store(Request $request)
    {
        if ($request->filled('oculto')) {
            return back()->with("error", "formulario rechazado "); // posible bot detectado
        }

        $this->validate($request, $this->rules());
        return back()->with('success', ' Se agrega una noticia correctamente.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'titulo' => 'bail|required|string|min:3|max:100',
            'descripcion' => 'bail|required|string|min:1',
            'categoria' => 'bail|required|string|min:1|max:60',
            'imagen' => 'bail|required|image|mimes:jpeg,jpg,png,webp'
        ];
    }
    public function messages()
    {
        return [
            'titulo.required' => 'El titulo es necesario',
            'descripcion.required' => 'La descripción es necesaria',
            'categoria.required' => 'La categoría es necesaria',
            'imagen.required' => 'La imagen es necesaria',
            'titulo.string' => 'Debe ingresar un titulo válido',
            'descripcion.string' => 'Debe ingresar una descripcion válida',
            'categoria.string' => 'Debe ingresar una categoría válida',
            'imagen.mimes' => 'El formato de la imagen debe de ser en: jpeg,jpg,png,webp',
            'titulo.min' => 'El titulo debe contener al menos un caracter',
            'titulo.max' => 'El titulo no debe contener más de 100 caracteres',
            'descripcion.min' => 'La descripción debe contener al menos un caracter',
            'categoria.min' => 'La categoría debe contener al menos un caracter',
            'categoria.max' => 'La categoría no debe contener más de 60 caracteres',
        ];
    }
}
