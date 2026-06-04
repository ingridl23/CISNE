<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionProfesional extends FormRequest
{
    /**
     * Autorizar el uso del FormRequest.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Reglas de validación.
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|min:3|max:100',
            'especialidad' => 'required|string|min:3|max:100',
            'matricula' => 'nullable|string|min:5|max:30',
            'imagen' => $this->isMethod('post')
                ? 'required|image|mimes:jpeg,jpg,png,webp|max:2048'
                : 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048'
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'Debe ingresar un nombre válido.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no debe superar los 100 caracteres.',

            'especialidad.required' => 'La especialidad es obligatoria.',
            'especialidad.string' => 'Debe ingresar una especialidad válida.',
            'especialidad.min' => 'La especialidad debe tener al menos 3 caracteres.',
            'especialidad.max' => 'La especialidad no debe superar los 100 caracteres.',

            'matricula.min' => 'La matrícula debe tener al menos 5 caracteres.',
            'matricula.max' => 'La matrícula no debe superar los 30 caracteres.',

            'imagen.required' => 'Debe subir una imagen.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser jpeg, jpg, png o webp.',
            'imagen.max' => 'La imagen no debe superar los 2MB.',
        ];
    }
}
