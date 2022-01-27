<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User, File};

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function() {
                return User::factory()->create()->id;
            },
            'model_type' => File::class,
            'model_id' => function() {
                return File::factory()->create()->id;
            },
            'content' => $this->faker->sentence
        ];
    }
}
