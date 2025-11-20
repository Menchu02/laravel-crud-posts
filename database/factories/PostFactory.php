<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //Genera Título aleatorio
            //SENTENCE() = ORACION
            "title"=>fake()->sentence(),
            //Genera una palabra aleatoria para la categoría.
            "category"=>fake()->word(),
            //Genera un texto de hasta 1000 caracteres.
            "content"=>fake()->text(1000),
            //Genera una fecha y hora aleatoria.
            "published_at"=>fake()->dateTime(),
        ];
    }
}
