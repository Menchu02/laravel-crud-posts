<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Calendar API Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container text-center mt-5">
   
    

    @if (Auth::check())
        <div>
            Bienvenido, {{ Auth::user()->name }} 
        </div>

        <a href="{{ route('book.meeting') }}" >
             Crear reunión de prueba
        </a>
        <br>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    @else
        <a href="{{ route('google.redirect') }}">
            Conectar con Google
        </a>
    @endif
</div>

</body>
</html>
