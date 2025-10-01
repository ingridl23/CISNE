<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Requests\validacionNoticia;
use Illuminate\Foundation\Http\FormRequest;

class validacionEditarNoticia extends validacionNoticia
{


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
            'imagen' => 'bail|image|mimes:jpeg,jpg,png,webp'
        ];
    }
}
