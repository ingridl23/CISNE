<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class validacionHogar  extends FormRequest
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


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'imagenes' => 'required|array|max:5',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048|dimensions:max_width=1920,max_height=1080',
            'nombre' => 'bail|required|string|min:3|max:100',
            'descripcion' => 'bail|required|string|min:10',
            'facebook' => 'nullable|string|min:3|max:100',
            'instagram' => 'nullable|string|min:3|max:100',
            'whatsapp' => 'numeric|digits_between:8,11',
            "provincia" => "required|string",
            "localidad" => "required|string",
            'ciudad' => 'bail|required|string',
            'calleYAltura' => 'bail|required|string'
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no debe superar los 100 caracteres.',

            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',


            'imagen.required' => 'Debes subir al menos una imagen.',
            'imagenes.required' => 'Debes subir al menos una imagen.',
            'imagenes.array' => 'Las imágenes deben enviarse como un arreglo.',
            'imagenes.max' => 'No puedes subir más de 5 imágenes.',

            'imagenes.*.image' => 'Cada archivo debe ser una imagen.',
            'imagenes.*.mimes' => 'Las imágenes deben estar en formato: jpeg, png, jpg, gif, svg o webp.',
            'imagen.mimes' => 'Las imágen deben estar en formato: jpeg, png, jpg, svg o webp.',
            'imagenes.*.max' => 'Cada imagen no debe pesar más de 2 MB.',
            'imagenes.*.dimensions' => 'Cada imagen debe tener un máximo de 1920px de ancho y 1080px de alto.',

            'facebook.string' => 'El enlace de Facebook debe ser un texto.',
            'facebook.min' => 'El enlace de Facebook debe tener al menos 3 caracteres.',
            'facebook.max' => 'El enlace de Facebook no debe superar los 100 caracteres.',

            'instagram.string' => 'El enlace de Instagram debe ser un texto.',
            'instagram.min' => 'El enlace de Instagram debe tener al menos 3 caracteres.',
            'instagram.max' => 'El enlace de Instagram no debe superar los 100 caracteres.',

            'whatsapp.numeric' => 'El número de WhatsApp debe contener solo números.',
            'whatsapp.digits_between' => 'El número de WhatsApp debe tener entre 8 y 11 dígitos.',

            'provincia.required' => 'La seleccion de una provincia es necesaria',

            'localidad.required' => 'La localidad es obligatoria.',
            'localidad.string' => 'La localidad debe ser un texto.',

            'ciudad.required' => 'La ciudad es obligatoria.',
            'ciudad.string' => 'La ciudad debe ser un texto.',

            'calleYAltura.required' => 'La calle es obligatoria.',
            'calleYAltura.string' => 'La calle debe ser un texto.',


        ];
    }
}
