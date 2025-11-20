<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Esto genera 100 posts usando el PostFactory
        //Cada post tendrá datos aleatorios según la definición del factory 
        //(title, category, content, published_at).
          Post::factory(100)->create();





        //-----------------------------------------------------------
        // $post= new Post();
        // $post->title="Post 1";
        // $post->category="Categoria 1";
        // $post->content= "Contenido 1";
        // $post->published_at=now();
        // $post->save(); 

        //  $post= new Post();
        // $post->title="Post 2";
        // $post->category="Categoria 2";
        // $post->content= "Contenido 2";
        // $post->published_at=now();
        // $post->save();
     
     


    }
}
