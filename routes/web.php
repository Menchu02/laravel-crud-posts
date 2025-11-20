<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Importamos todos los controladores necesarios
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;









// Route::get('/', HomeController::class);
//RUTA USERS:
Route::get("/users",[UserController::class,"index"])->name("users.index");



Route::get('/', function () {
    return view('welcome');
});

Route::post("/logout",function(){
    Auth::logout();
    return redirect("/");
})->name("logout");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/meeting', function () {
    return view('meeting');
})->middleware('auth')->name('meeting');

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallBack']);
Route::get('book-meeting', [GoogleAuthController::class, 'bookMeeting'])->name('book.meeting');



//  (CRUD)
// Orden:  SIEMPRE Fijo antes que Dinámico


// INDEX: GET /posts
// Muestra el listado de todos los posts
Route::get("/posts", [PostController::class, "index"])->name("posts.index");


// CREATE: GET /posts/create  
// Muestra el formulario para crear un nuevo post.
Route::get("/posts/create", [PostController::class, "create"])->name("posts.create");

// STORE: POST /posts
// Procesa y guarda los datos enviados desde el formulario 'create'.
Route::post("/posts", [PostController::class, "store"])->name("posts.store");


// EDIT: GET /posts/{post}/edit  
// Muestra el formulario para editar un post específico.
Route::get("/posts/{post}/edit", [PostController::class, "edit"])->name("posts.edit");


//BUY: POST //post/{post}/buy
//Gestiona la compra de un post a cambio de un email

Route::post("/post/{post}/buy", [PostController::class, "buy"])->name("posts.buy");


// UPDATE: PUT/PATCH /posts/{post}
// Procesa y guarda los cambios de un post específico.
Route::put("/posts/{post}", [PostController::class, "update"])->name("posts.update");


// DESTROY: DELETE /posts/{post}
// Elimina un post específico.
Route::delete("/posts/{post}", [PostController::class, "destroy"])->name("posts.destroy");




// SHOW: GET /posts/{post}  
// Muestra un post individual. (Debe ir al final para que 'create' y 'edit' no colisionen).
Route::get("/posts/{post}", [PostController::class, "show"])->name("posts.show");


// ----------------------------------------------------------------------
// 3. RUTAS DE PRUEBA Y DESARROLLO (Ejemplos Eloquent)
// ----------------------------------------------------------------------

// Ruta de prueba para ejecutar código Eloquent
Route::get("/prueba", function () {
    return "Hola desde prueba";
    // DESDE AQUÍ COMIENZO A MODIFICAR AÑADIR ELIMINAR, ETC, LOS REGISTROS, CAMPOS
    // DE LA TABLA POST
    
    // 1. CREAR NUEVO POST Y AÑADIRLO A LA TABLA:
    // $post = new Post;
    // $post->title = "tiTulO de pruebA 10";
    // $post->content = "ContenidO prueba 10";
    // $post->category = "desarrollo";
    // $post->save();
    // return $post;

    // 2. ACTUALIZAR MODIFICAR UN POST EXISTENTE:
    // Filtra por id:
    // $post = App\Models\Post::find(1); // Es necesario usar App\Models\Post aquí
    // dd($post->is_active);

    // 3. ELIMINAR UN REGISTRO:
    // $post=App\Models\Post::find(1);
    // $post->delete();
    // return $post . " ha sido eliminado";
    
    // Devolvemos el estado actual del post para la ruta de prueba
    // return dd($post->is_active);
});
