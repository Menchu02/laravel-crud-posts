<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'post_id',
        'email',
        'status',
        'purchase_token',
    ];


    //La función post() define una relación belongsTo, lo cual nos permite
    // cargar el objeto Post asociado a una compra de forma eficiente,
    // utilizando la columna post_id como clave foránea."
       public function post()
    {
        return $this->belongsTo(\App\Models\Post::class);
    }
}
