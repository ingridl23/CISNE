<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use Illuminate\Contracts\Mail\Mailable;
use App\Mail\envioDeForm;
use App\Models\institucion_contacto;
use App\Models\Paciente_contacto;
use App\Models\ProfesionalEnvioCV;
use App\Http\Requests\validacionFormularioContacto;
use App\Mail\confirmacionFormulario;

class FormController extends Controller
{
    //

    function contacto(){
       return view('layouts.formulario');
    }
/*
public function enviar(Request $request)
{
    Log::info($request->all());

    Mail::raw('Test desde formulario', function ($message) {
        $message->to('cisneconsultorios@gmail.com')
                ->subject('Test formulario');
    });

    return back()->with('success','Mensaje enviado');
}
*/

    function enviar(validacionFormularioContacto $request){
//dd($request->all());
        if ($request->filled('oculto')) {
            return back()->with("error", "Formulario rechazado")->withInput();
        }

        try {
            $cvPath = null;
            $opcion = $request->opcion;
            $data = []; // valor por defecto

            if ($opcion === 'profesional') {
                // Subir el archivo CV si está presente
                if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
                    $cvPath = $request->file('cv')->store('cvs', 'public');
                } else {
                    return back()->withErrors(['cv' => 'Archivo de currículum inválido'])->withInput();
                }

                // Guardar en la base de datos
                $empleoData = [
                 'nombre' => $request->name,
                    'email' => $request->email,
                    'telefono' => $request->tel,
                    'cv_path' => $cvPath,
                ];

                ProfesionalEnvioCV::create($empleoData);


                // Preparar datos para enviar por correo si es un profesional
                $data = $request->except('cv');
                $data['cv'] = $request->file('cv');
            }
            // ========== paciente que se comunica mediante el formulario ==========
            elseif ($opcion === 'particular') {

                $data =  $request->all();

                // Guardar en la base de datos
                $pacienteData = [
                    'nombre' => $request->name,
                    'email' => $request->email,
                    'telefono' => $request->tel,

                ];

                 Paciente_contacto::create($pacienteData);
            }
            // ========== intitucion  ==========
            elseif ($opcion === 'institucion') {

                $data =  $request->all();
                // Guardar en la base de datos
                 $institucionData = [
                    'nombre' => $request->name,
                    'email' => $request->email,
                    'telefono' => $request->tel,

                ];

                 institucion_contacto::create($institucionData);
            }


            // Enviar correo en todos los casos
            Mail::to('cisneconsultorios@gmail.com')->send(new envioDeForm($data));

            return back()->with('success', 'Enviado correctamente,en la brevedad el equipo Cisne se pondra en contacto.');

             // confirmación automática al usuario
            Mail::to($request->email)->send(new confirmacionFormulario($data));
        } catch (\Exception $e) {
            Log::error('Error al enviar el formulario: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al enviar el formulario.');
        }
    }


}
