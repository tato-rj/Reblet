<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\File;

class SupportDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->word,
            'file_id' => function() {
                return File::factory()->create()->id;
            }
        ];
    }
}
