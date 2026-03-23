<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\envioDeForm;
use App\Models\InstitucionContacto;
use App\Models\Paciente_contacto;
use App\Models\ProfesionalEnvioCV;
use App\Http\Requests\validacionFormularioContacto;
use App\Mail\confirmacionFormulario;
use Illuminate\Support\Facades\Storage;

/**
 * @class FormController
 * @brief Controlador encargado del manejo del formulario de contacto.
 *
 * Gestiona el envío de formularios desde la web, contemplando
 * distintos tipos de usuarios:
 *
 * - Profesionales (envío de CV)
 * - Pacientes/particulares
 * - Instituciones
 *
 * Funcionalidades principales:
 * - Validación de datos del formulario
 * - Almacenamiento en base de datos según el tipo
 * - Subida de archivos (CV)
 * - Envío de correos (notificación + confirmación)
 *
 * @package App\Http\Controllers
 */
class FormController extends Controller
{
    //
/**
 * @brief Muestra la vista del formulario de contacto.
 *
 * @return \Illuminate\View\View
 */
    function contacto(){
       return view('layouts.formulario');
    }




    /**
 * @brief Procesa y envía el formulario de contacto.
 *
 * Este método maneja distintos tipos de formularios según el campo "opcion":
 *
 * - profesional:
 *   - Valida y almacena el CV
 *   - Guarda los datos en la tabla ProfesionalEnvioCV
 *
 * - particular:
 *   - Guarda los datos en la tabla Paciente_contacto
 *
 * - institucion:
 *   - Guarda los datos en la tabla InstitucionContacto
 *
 * Funcionalidades adicionales:
 * - Protección contra bots mediante campo oculto (honeypot)
 * - Envío de correo al administrador
 * - Envío de correo de confirmación al usuario
 *
 * @param validacionFormularioContacto $request Datos validados del formulario
 *
 * @return \Illuminate\Http\RedirectResponse
 *
 * @throws \Exception En caso de error en envío de correo o almacenamiento
 */

    function enviar(validacionFormularioContacto $request){

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
              
              $institucionData = [
                  'nombre' => $request->name,
                  'email' => $request->email,
                  'telefono' => $request->tel,
                  ];
                  
                          //    dd($institucionData);
           InstitucionContacto::create($institucionData);
}


            // Enviar correo en todos los casos
            Mail::to('cisneconsultorios@gmail.com')->send(new envioDeForm($data));
          
            
          // confirmación automática al usuario
           Mail::to($request->email)->send(new confirmacionFormulario($data));
            return back()->with('success', 'Enviado correctamente,en la brevedad el equipo Cisne se pondra en contacto.');
        // BORRAR ARCHIVO LOCAL
              if ($cvPath) {
                 Storage::disk('public')->delete($cvPath);
             }
            } catch (\Exception $e) {
            Log::error('Error al enviar el formulario: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al enviar el formulario.');
        }
    }


}
