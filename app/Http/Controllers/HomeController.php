<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfesionalesModel;
use App\Models\HogarModel;
use App\Models\ImagesHogarModel;
use Illuminate\Support\ViewErrorBag;

/**
 *
 *@Brief Clase Controller de la Homepage del sitio Cisne Consultorios
 *@since 2025,septiembre
 *@Author Ingrid Ledesma , Tec.Desarrollo Aplicaciones Informaticas.
 *
 * @todo  Queda pendiente en caso que se necesite modificar el metodo dei magenes relacionadas con profesionales, en caso
 * que se necesite iterar mas de una imagen por cada uno de ellos.
 */


/**
 * @class HomeController
 * @brief Controlador de la página principal del sitio Cisne Consultorios.
 *
 * Este controlador se encarga de:
 * - Obtener y mostrar los profesionales registrados
 * - Obtener y mostrar las instituciones (hogares)
 * - Cargar relaciones asociadas (imágenes, dirección, redes)
 *
 * La información se envía a la vista principal del sistema (homepage).
 *
 * @since 2025-09
 * @author Ingrid Ledesma
 *
 * @todo Evaluar soporte para múltiples imágenes por profesional en futuras versiones.
 */
class HomeController extends Controller
{

/**
 * @brief Muestra la página principal del sitio.
 *
 * Obtiene los datos necesarios para renderizar la homepage:
 * - Profesionales con sus imágenes asociadas
 * - Instituciones (hogares) con imágenes, dirección y redes sociales
 *
 * Además, envía los errores de sesión a la vista en caso de existir.
 *
 * @return \Illuminate\View\View Vista principal del sitio
 */

    public function index()
    {
        abort(500, 'PRUEBA-INGRID-2026');
        // Profesionales
        $profesionales = ProfesionalesModel::with('imagenes')->paginate(12);

  dd([
        'profesionales_count' => $profesionales->count(),
        'primer_profesional' => $profesionales->first(),
    ]);

        // Hogares
        $hogares = HogarModel::with('imagenes','direccion','redes')->paginate(12);

        return view('layouts.templateHome', [
            'profesionales' => $profesionales,
            'hogares' => $hogares,
            'errors' => session()->get('errors') ?: new ViewErrorBag,
        ]);
    }
}
