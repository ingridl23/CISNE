<?php

namespace App\Services;

use Cloudinary\Cloudinary;

/**
 * @class CloudinaryService
 * @brief Subida y borrado de imágenes en Cloudinary.
 *
 * Usa el SDK oficial (cloudinary/cloudinary_php) directamente, sin el
 * paquete cloudinary-labs/cloudinary-laravel (que no soporta Laravel 13).
 *
 * La conexión se configura con la variable CLOUDINARY_URL del .env:
 *   CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME
 */
class CloudinaryService
{
    private ?Cloudinary $cliente;

    /**
     * @param Cloudinary|null $cliente Cliente ya configurado (útil en tests).
     *                                 Si es null, se crea al primer uso con config('cloudinary.cloud_url').
     */
    public function __construct(?Cloudinary $cliente = null)
    {
        $this->cliente = $cliente;
    }

    /**
     * @brief Sube un archivo a una carpeta de Cloudinary.
     *
     * @param string $ruta    Ruta local del archivo (ej. $request->file('imagen')->getRealPath())
     * @param string $carpeta Carpeta destino en Cloudinary (profesionales, noticias, instituciones)
     * @return array{url: string, public_id: string}
     *
     * @throws \Cloudinary\Api\Exception\ApiError Si Cloudinary rechaza la subida
     */
    public function subir(string $ruta, string $carpeta): array
    {
        $respuesta = $this->cliente()->uploadApi()->upload($ruta, ['folder' => $carpeta]);

        return [
            'url' => $respuesta['secure_url'],
            'public_id' => $respuesta['public_id'],
        ];
    }

    /**
     * @brief Borra una imagen de Cloudinary por su public_id.
     *
     * No hace nada si $publicId está vacío.
     *
     * @throws \Cloudinary\Api\Exception\ApiError Si Cloudinary rechaza el borrado
     */
    public function borrar(?string $publicId): void
    {
        if (empty($publicId)) {
            return;
        }

        $this->cliente()->uploadApi()->destroy($publicId);
    }

    private function cliente(): Cloudinary
    {
        if ($this->cliente === null) {
            $url = config('cloudinary.cloud_url');

            if (empty($url)) {
                throw new \RuntimeException('Falta configurar CLOUDINARY_URL en el .env');
            }

            $this->cliente = new Cloudinary($url);
        }

        return $this->cliente;
    }
}
