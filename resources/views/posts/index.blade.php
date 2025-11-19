<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 11</title>
</head>
<body>
    <h1>Posts:</h1>
    
    {{-- BUSCADOR --}}
  <form method="GET" action="{{ route('posts.index') }}" >
    <input
        type="text"
        name="search"
          {{-- Mantiene el valor buscado después de recargar la página --}}
        value="{{ request('search') }}" 
        placeholder="Buscar por título"
    
    >
    <button type="submit">Buscar</button>
 </form>
  {{-- Botón para limpiar la búsqueda --}}
        @if (request('search'))
            <a href="{{ route('posts.index') }}" class="clear-link">Limpiar Búsqueda</a>
        @endif
  

      <a href="{{route("posts.create")}}">Crear nuevo post </a>
    <ul>
        {{-- <p>{{$posts}}</p> --}}
        @foreach ($posts as $item)
            <li><a href="{{route("posts.show",$item)}}">{{$item->title}}</a>
               
            </li>
         @endforeach   
        
    </ul>
    
    {{-- paginado  --}}
    {{-- {{$posts->links()}} --}}
  
</body>
</html>