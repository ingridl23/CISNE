<!DOCTYPE html>
<html>

<head>
    <title>Nuevo mensaje desde formulario CISNE</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Nuevo mensaje desde el sitio Consultorios Cisne </h1>

    <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Teléfono:</strong> {{ $data['tel'] ?? 'No provisto' }}</p>

    <p><strong>Grupo seleccionado:</strong> {{ ucfirst($data['opcion']) }}</p>

    @if ($data['opcion'] === 'institucion')
        <hr>
        <h3>Datos de la Institucion</h3>
        <p><strong>Nombre de la institucion:</strong> {{ $data['name'] ?? 'No provisto' }}</p>
    @elseif ($data['opcion'] === 'particular')
        <hr>
        <h3>Datos del paciente</h3>
        <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Teléfono:</strong> {{ $data['tel'] ?? 'No provisto' }}</p>
    @elseif ($data['opcion'] === 'profesional')
        <hr>
        <h3>Datos de quien busca una entrevista laboral en CISNE </h3>

        <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Teléfono:</strong> {{ $data['tel'] ?? 'No provisto' }}</p>
        <p><strong>CV cargado:</strong> {{ isset($data['cv']) && $data['cv'] ? 'Sí' : 'No' }}</p>
    @endif

    <hr>
    <p>enviado desde sistema ,<br>{{ config('app.name') }}</p>
</body>

</html>
