<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId("post_id")->constrained()->onDelete("cascade");
            $table->string("email");
            $table->string("status")->default("pending");
            $table->string("purchase_token")->nullable()->unique();
            $table->timestamps();

            //INDICE COMPUESTO:
            //Herramienta de optimizacion, busca primero x el post_id el o los emails q le corresponde           $table->index(["post_id", "email"]);
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
