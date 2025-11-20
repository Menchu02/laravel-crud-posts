<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Purchase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseConfirmation;
// Inyeccion de dependencias.
// Dependencias, herramientas o servicios de Laravel
use Illuminate\Http\Request;


class PostController extends Controller
{
    
    // 1. INDEX: Muestra todos los posts (Listado)
    public function index(Request $request){
        
        // 1. Comenzar la consulta base de Eloquent
        $query = Post::orderBy("id", "desc");

    // Filtro “starts with”: coincidencia al inicio
    if ($request->filled('search')) {
        $query->where('title', 'like', $request->search . '%');
    }

        // 3. Obtener los resultados
        // IMPORTANTE: Aplicamos orderBy o ej paginate() a la variable $query
        $posts = $query->get();
        


        // Ordena por ID de mayor a menor (los más nuevos primero)
        // $posts = Post::orderBy("id", "desc")->paginate(20);
        return view("posts.index", compact("posts"));
    }

    // 2. CREATE: Muestra el formulario para crear un nuevo post (Ruta Fija)
    public function create()
    {
        return view("posts.create"); 
    }

    //CREAR EN LA BASE DE DATOS
    // 3. STORE: Guarda los datos de un nuevo post en la BD (POST)
    public function store(Request $request){
        // dd($request->all());

       //VALIDACIONES FORMULARIO:
        $request->validate([
            "title"=>"required|min:3|max:100",
            "category"=>"required|min:3|max:50",
            "content"=>"required|min:10"
        ],[
            // Mensajes para REQUIRED
           "title.required" => "El título es obligatorio.",
           "category.required" => "La categoría es obligatoria.",
           "content.required" => "El contenido es obligatorio." ,
            // Mensajes para MIN/MAX
           "title.min" => "El título debe tener al menos 3 letras.",
           "title.max" => "El título es demasiado largo, máximo 100 caracteres.",
           "content.min" => "El contenido debe tener al menos 10 caracteres para ser interesante.",
           "category.min"=>"La categoría debe tener al menos 3 letras",

        ]);

        // return $request->all();

        //ASIGNACION MAXIVA:
         Post::create($request->all());

         //ASIGNACION MANUAL:
         // $post = new Post();
        // $post->title = $request->title;
        // $post->category = $request->category;
        // $post->content = $request->content;

        // $post->save();
        
        // Redirige al listado principal con el nuevo post
        return redirect("/posts");
    }

    // 4. SHOW: Muestra un post en concreto (Ruta Dinámica)
    // Usamos Inyección de Modelo (Post $post) para que Laravel lo encuentre automáticamente
    public function show($post)
    {
         $post=Post::find($post);
        // Laravel ya encontró el registro completo, id, title, content....
        // gracias a la inyección de modelo. No necesitamos Post::find().
        return view("posts.show", compact("post"));
    }

    // 5. EDIT: Muestra el formulario para editar un post en concreto
    // Usamos Inyección de Modelo para que Laravel lo encuentre automáticamente
    public function edit(Post $post)
    {
        // recuperamos el post q queremos editar
        // mandamos a la vista (que es un formulario) la info del post que queremos editar
        return view("posts.edit", compact("post"));
    }

    // 6. UPDATE: Método que recibe los datos modificados en el formulario de edit (PUT/PATCH)
    // Recibe por parámetro el objeto Post que se debe modificar y los cambios realizados en $request
    public function update(Request $request, Post $post)
    {
        //Asignacion masiva:
        $post->update($request->all());


       
        // Asignacion manual:
        // $post->title = $request->title;
        // $post->category = $request->category;
        // $post->content = $request->content;

        // $post->save();

        // cuando acabe la función, llévame a la url individual del post
       return redirect()->route('posts.show', $post);
    }

    // 7. DESTROY: Elimina un post en concreto (DELETE)
    // Usamos Inyección de Modelo para que Laravel lo encuentre automáticamente
    public function destroy(Post $post)
    {
        // Usamos el método delete() de Eloquent sobre el objeto ya encontrado
        $post->delete();

        // Redirige al listado de posts después de eliminar
        return redirect("/posts");
        // return "post que queremos eliminar es {$post->id}"; // Línea de depuración anterior
    }


    //Metodo comprar un post
    public function buy(Request $request, Post $post){
        //Validacion email
        $data= $request->validate([
            //debe existir, debe ser formato emial, y no mas de 225 caracteres
            "email"=>["required","email","max:255"],
        ]);

        //Evitar duplicados:(Lógica de negocio)
        //usa el Modelo para consultar la tabla de la BD
        //Busca en Purchase si la columna post-id coincide con el id del post q quermos comprar
        //""       ""    si la columna emial coincide con el email que el usuario introdujo
        //que fue validado en el paso anterior 
        $existing=Purchase::where("post_id", $post->id)->where("email", $data["email"])->first();
        if($existing){
            return redirect()->back()->with("warning","Este correo ya ha comprado este post");
        };

        //Guardar datos de la compra en BD
        $purcheses= Purchase::create([
            "post_id"=>$post->id,
            "email"=>$data["email"],
            "status"=>"completed",
            "purchase_token"=>Str::uuid()->toString()


        ]);
       return redirect()->back()->with('success', 'Compra realizada con éxito.');




    }
    

    
}
