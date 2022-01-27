<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Revision, User};

class FileFactory extends Factory
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
            'name' => $this->faker->word,
            'path' => $this->faker->url,
            'type' => $this->faker->word,
            'url' => $this->faker->url,
            'size' => $this->faker->randomNumber(),
            'extension' => $this->faker->word,
            'revision_id' => function() {
                return Revision::factory()->create()->id;
            },
        ];
    }
}
