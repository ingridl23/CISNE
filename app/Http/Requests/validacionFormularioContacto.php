<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class validacionFormularioContacto  extends FormRequest
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
    $rules = [
        'name' => 'bail|required|string|min:3|max:100',
        'opcion' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'tel' => 'nullable|numeric|digits_between:8,11',
        'oculto' => 'nullable|string',
    ];

    $opcion = $this->input('opcion');

    // Si el contacto es profesional, exigir CV
    if ($opcion === 'profesional') {
        $rules['cv'] = 'required|file|mimes:pdf|max:2048';
    }

    return $rules;
}







    public function messages()
    {
        return [
            'name.required' => 'El nombre es necesario',
            'name.string' => 'Debe ingresar un nombre válido',
            'name.min' => 'Debe ingresar más de una letra',
            'name.max' => 'No se puede ingresar más de 100 caracteres',

            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El formato del email es inválido.',
            'email.max' => 'El email no puede tener más de 255 caracteres.',

            /*'description.required' => 'La descripción es necesaria',
            'description.string' => 'Debe ingresar una descripción válida',
            'description.min' => 'Debe ingresar más de 20 caracteres',
            'description.max' => 'No se puede ingresar más de 300 caracteres',*/

            'tel.numeric' => 'Debe ingresar un número de teléfono válido',
            'tel.digits_between' => 'El número de teléfono debe tener entre 8 y 11 dígitos',

            'opcion.required' => 'Debe seleccionar una opción',
            
            'cv.required' => 'Debe subir su currículum en formato PDF.',
            'cv.file' => 'El archivo debe ser válido.',
            'cv.mimes' => 'Solo se acepta formato PDF.',
            'cv.max' => 'El archivo no debe superar los 2 MB.',

        ];
    }
}
