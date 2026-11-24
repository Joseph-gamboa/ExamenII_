<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="{{ asset('theme/libs/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}">
</head>

<body class="bg-light">
    <main class="d-flex align-items-center justify-content-center">
        <div class="card shadow-sm p-4 text-center" style="max-width:380px;width:100%">
            <h3 class="mb-2">Mis Listas</h3>
            <p class="text-muted">Inicia sesión para administrar tus listas</p>
            <a href="{{ route('google') }}" class="btn btn-danger w-100">
    Iniciar sesión con Google
</a>
        </div>
    </main>
    <script src="{{ asset('theme/libs/jquery/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('theme/libs/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
