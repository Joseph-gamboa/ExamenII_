<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis listas</title>
    <link rel="stylesheet" href="{{ asset('theme/libs/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}">
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container"><a class="navbar-brand" href="index.html">Mis Listas</a>
            <div class="d-flex align-items-center text-white gap-3"><span>Juan Pérez</span><a href="login.html"
                    class="btn btn-outline-light btn-sm">Cerrar sesión</a></div>
        </div>
    </nav>
    
@yield('contenido')

    <script src="{{ asset('theme/libs/jquery/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('theme/libs/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>$(".form-eliminar").on("submit", function (e) { if (!confirm("¿Seguro que desea eliminar esta lista?")) e.preventDefault(); });</script>
</body>

</html>