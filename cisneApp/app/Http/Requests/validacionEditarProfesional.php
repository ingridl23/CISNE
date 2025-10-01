<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class validacionEditarProfesional extends FormRequest
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
            'nombre'=>'bail|required|string|min:1|max:100',
            'descripcion'=>'bail|required|string|min:1',
            'profesion'=>'bail|required|string|min:20|max:70',
            'imagen' => 'array|max:1',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'matricula'=> 'bail|required|string|min:6|max:12'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es necesario',
            'descripcion.required' => 'La descripcion es necesaria',
            'profesion.required' => 'Indicar la profesion es necesario',
            'nombre.string' => 'Debe ingresar un nombre valido',
            'descripcion.string' => 'Debe ingresar una descripcion valida',
            'imagen.mimes' => 'El formato de la imagen debe de ser en: jpeg,jpg,png,webp',
            'nombre.min' => 'El nombre debe contener al menos 10 caracter',
            'nombre.max' => 'El nombre no debe contener más de 70 caracteres',
        ];
    }
}
