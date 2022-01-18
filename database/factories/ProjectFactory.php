<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'creator_id' => function() {
                return User::factory()->create()->id;
            },
            'name' => $this->faker->sentence,
            'description' => $this->faker->sentence
        ];
    }
}
