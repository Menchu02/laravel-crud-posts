
@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">


    @if(session('meetLink'))
    
        <a href="{{ session('meetLink') }}" target="_blank" ">
            Unirme a la reunión
        </a>
        <p>Enlace: </p>
        <input type="text"  value="{{ session('meetLink') }}" readonly>
       
    @else
        <p>No se ha encontrado ningún enlace de reunión.</p>
    @endif
</div>
@endsection
