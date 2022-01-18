<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Project, User};

class FolderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $project = Project::factory()->create();

        return [
            'creator_id' => function() {
                return User::factory()->create()->id;
            },
            'name' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'project_id' => function() use ($project) {
                return $project->id;
            },
            'parent_type' => Project::class,
            'parent_id' => function() use ($project) {
                return $project->id;
            }
        ];
    }
}
