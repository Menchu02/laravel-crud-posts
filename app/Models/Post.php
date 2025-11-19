<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
 use HasFactory; 


    //este modelo que tabla de la base de bato debe administrar?? la tabla Post...
    //ESTE MODELO SE CONECTA CON AL TABLA POST 
    protected $table ="posts";


    //Define datos q se pueden rellenar x asignación maxiva
     protected $fillable = [
        'title', 
        'content', 
        'category', 
        'published_at',
        'is_active',
        // 'created_at', 
        // 'updated_at',
    ];

    public function purchases(){
        return $this->hasMany(\App\Models\Purchase::class);
    }


    //MUTADORES:
    //METODO Q CONTROLA COMO SE ESTA GUARDANDO LA INFORMACION DENTRO
    //DE LA BASE DE DATOS
    //el campo que le añadas antes de Attribute es al campo q se aplica
    protected function title():Attribute {
        return Attribute::make(
            //SET PARA GUARDAR EN BASE DE DATOS
            set:function($value){
                return strtolower($value);
            },
            // GET PARA CUANDO RECUPERA EL VALOR DE LA BD PARA REENDERIZARLO
            // EN EL NAVEGADOR WEB
            get:function ($value){
                return ucfirst($value);
            }

        );
    }

    //CASTING: QUE TIPO DE DATO QUIERO Q SEA ESTA PROPIEDAD(CAMPO)
    //AQUI DEFINO Q QUIERO Q SEAN TIPO DATATIME
    protected function casts():array {
        return [
            //NOMBRE DEL CAMPO Y COMO QUIERO QUE LO TRATE
            "published_at" =>"datetime",
            "is_active"=>"boolean"
        ];
    }


}
 