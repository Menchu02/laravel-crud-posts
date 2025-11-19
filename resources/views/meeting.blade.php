
@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2> Reunión creada con éxito</h2>

    @if(session('meetLink'))
    
        <a href="{{ session('meetLink') }}" target="_blank" ">
            Unirme a la reunión
        </a>
    @else
        <p>No se ha encontrado ningún enlace de reunión.</p>
    @endif
</div>
@endsection
