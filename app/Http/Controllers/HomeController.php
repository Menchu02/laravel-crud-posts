<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //AQUI VA TODA LA LOGICA(METODOS) DE ESTA RUTA EN CONCRETO 
    //Q ES CONTROLADA X ESTE CONTROLLER
    //invoke es un metodo magico
    public function __invoke() {
        return view("home");
        }
    
        
}
