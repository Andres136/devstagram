<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
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
          'titulo' => $this->faker->sentence(5),
          'descripcion' => $this->faker->paragraph(20),
          'imagen' => $this->faker->uuid() . '.jpg',
          'user_id' => $this->faker->randomElement([1, 2, 3])
        ];
    }
}
