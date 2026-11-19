<?php

namespace Tests\Unit;

use App\Services\CloudinaryService;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Mockery;
use Tests\TestCase;

class CloudinaryServiceTest extends TestCase
{
    public function test_subir_devuelve_url_y_public_id()
    {
        $uploadApi = Mockery::mock(UploadApi::class);
        $uploadApi->shouldReceive('upload')
            ->once()
            ->with('/tmp/foto.jpg', ['folder' => 'noticias'])
            ->andReturn(new ApiResponse([
                'secure_url' => 'https://res.cloudinary.com/demo/noticias/abc.jpg',
                'public_id' => 'noticias/abc',
            ], []));

        $cliente = Mockery::mock(Cloudinary::class);
        $cliente->shouldReceive('uploadApi')->andReturn($uploadApi);

        $resultado = (new CloudinaryService($cliente))->subir('/tmp/foto.jpg', 'noticias');

        $this->assertSame([
            'url' => 'https://res.cloudinary.com/demo/noticias/abc.jpg',
            'public_id' => 'noticias/abc',
        ], $resultado);
    }

    public function test_borrar_llama_a_destroy()
    {
        $uploadApi = Mockery::mock(UploadApi::class);
        $uploadApi->shouldReceive('destroy')->once()->with('noticias/abc')
            ->andReturn(new ApiResponse(['result' => 'ok'], []));

        $cliente = Mockery::mock(Cloudinary::class);
        $cliente->shouldReceive('uploadApi')->andReturn($uploadApi);

        (new CloudinaryService($cliente))->borrar('noticias/abc');
    }

    public function test_borrar_sin_public_id_no_hace_nada()
    {
        $cliente = Mockery::mock(Cloudinary::class);
        $cliente->shouldNotReceive('uploadApi');

        $servicio = new CloudinaryService($cliente);
        $servicio->borrar(null);
        $servicio->borrar('');

        $this->assertTrue(true);
    }

    public function test_sin_cloudinary_url_da_error_claro()
    {
        config(['cloudinary.cloud_url' => null]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('CLOUDINARY_URL');

        (new CloudinaryService())->subir('/tmp/foto.jpg', 'noticias');
    }

    public function test_crea_el_cliente_real_desde_la_config()
    {
        // URL con credenciales falsas: solo verifica que el SDK la acepta (no hace requests)
        config(['cloudinary.cloud_url' => 'cloudinary://123456:secreto@demo']);

        $servicio = new CloudinaryService();
        $metodo = new \ReflectionMethod($servicio, 'cliente');
        $cliente = $metodo->invoke($servicio);

        $this->assertInstanceOf(Cloudinary::class, $cliente);
        $this->assertSame('demo', $cliente->configuration->cloud->cloudName);
    }
}
