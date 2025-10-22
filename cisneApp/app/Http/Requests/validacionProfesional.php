<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;


class validacionProfesional extends FormRequest
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
return back()->with('success', ' Se agrega un profesional correctamente.');
}

/**
* Get the validation rules that apply to the request.
*
* @return array
*/

public function rules()
{

return [
'nombre' => 'bail|required|string|min:3|max:100',
'especialidad' => 'bail|required|string|min:20|max:100',
'matricula' => 'bail|required|string|min:5|max:30',
'imagen' => 'bail|required|image|mimes:jpeg,jpg,png,webp'
];
}


public function messages()
{
return [
'nombre.required' => 'El nombre es necesario',
'especialidad.required' => 'La especialidad es necesaria',
'matricula.required'=> 'La matricula es necesaria',
'imagen.required' => 'La imagen es necesaria',
'nombre.string' => 'Debe ingresar un nombre válido',
'especialidad.string' => 'Debe ingresar una especialidad',
'imagen.mimes' => 'El formato de la imagen debe de ser en: jpeg,jpg,png,webp',
'nombre.min' => 'El nombre debe contener mas de un caracter',
'nombre.max' => 'El nombre no debe contener más de 100 caracteres',
'matricula.min' => 'La matriucla debe contener al menos 5 caracter',
'matricula.max' => 'La categoría no debe contener más de 30 caracteres',
];
}



}
