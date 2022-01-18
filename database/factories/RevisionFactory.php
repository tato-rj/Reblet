<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Folder;

class RevisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'folder_id' => function() {
                return Folder::factory()->create()->id;
            }
        ];
    }
}
