<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 11</title>
</head>
<body>
    <a href="{{route("posts.index")}}">Volver a Posts</a>
    <h1>Formulario nuevo post</h1>
    @if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route("posts.store")}}" method="POST">
        {{--  @csrf , token de seguridad en Laravel --}}
        {{-- laravel espera que cada vez que hagamos un envio tipo POST , tb le mandemos un token --}}
        @csrf

        <label>
            Título
            <input type="text" name="title" value="{{ old('title') }}">
            {{-- old() RECUPERA EL VALOR QUE EL USUARIO HABIA ESCRITO --}}
        </label>
        <br>
         <br>
        <label>
            Categoria
            <input type="text" name="category" value="{{ old('category') }}">
        </label>
        <br>
         <br>
         <label>
            Contenido
             <textarea name="content">{{ old('content') }}</textarea>
         </label>
         <br>
         <br>
         <button type="submit"> Crear post</button>
        
    </form>
</body>
</html>