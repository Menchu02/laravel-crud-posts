<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//LAS MIGRACIONES SIRVEN PAA CREAR LAS
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->longText("content");
            $table->string("category");
            //timestamps crea created_at y update_at
            $table->timestamps();
            $table->timestamp("published_at")->nullable();
            $table->boolean("is_active")->default(true);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
