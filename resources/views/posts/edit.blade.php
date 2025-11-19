<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Formulario nuevo post</h1>
     {{-- este formulario manda la info del post de nuevo a la ruta posts/{{$post->id}}
     pero con una ruta diferente con metodo PUT --}}
    <form action="{{route("posts.update",$post->id)}}" method="POST">
        {{--  @csrf , token de seguridad en Laravel --}}
        {{-- laravel espera que cada vez que hagamos un envio tipo POST , tb le mandemos un token --}}
        @csrf
        {{-- el formulario solo contempla que en method vaya get o post(conseguir datos o Crear)
        nosotros queremos modificar por eso añadimos @method('PUT') --}}
        @method('PUT')

        {{-- a traves del controlador y su metodo edit estamos mandando a esta vista
        la info del post que queremos editar --}}
        <label>
            Título
            <input type="text" name="title" value="{{$post->title}}">
            {{-- a cada input le damos el value del post->propiedad para
            que se asigne directamente dentro del input y poder cambiarlo --}}
        </label>
        <br>
         <br>
        <label>
            Categoria
            <input type="text" name="category" value="{{$post->category}}">
        </label>
        <br>
         <br>
         <label>
            Contenido
             <textarea name="content" >{{$post->content}}</textarea>
         </label>
         <br>
         <br>
         <button type="submit">Actualizar Post</button>
        
    </form>
    
</body>
</html>