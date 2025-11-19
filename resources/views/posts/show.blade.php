<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 11</title>
</head>
<body>
     @if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
   <a href="{{route("posts.index")}}">Volver a Posts</a>

    <h1>Título: {{$post->title}} </h1>
    <p><b>Categoría:</b> {{$post->category}}</p>
    <p><b>Contenido:</b> {{$post->content}}</p>

    {{-- enlace que me lleva a editar en concreto el post a traves de su id --}}
    <a href="{{route("posts.edit",$post)}}">Editar</a>
     <br>
     <br>
    <form action="{{route("posts.destroy",$post)}}" method="POST">
           @csrf
           @method("DELETE")

            <button>Eliminar</button>
    </form>
     <br>
     <br>
    <form action="{{ route('posts.buy', $post->id) }}" method="POST">
    @csrf
    <label for="email">Para comprar, añade un email:</label>
    <input type="email" name="email" placeholder="Introduce tu correo" required>
    <button type="submit">Comprar</button>
</form>


</body>
</html>