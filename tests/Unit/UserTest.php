<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{User, Project, Team};

class UserTest extends AppTest
{
    /** @test */
    public function it_has_many_projects()
    {
        $this->login();

        create(Project::class, ['creator_id' => auth()->user()->id]);

        $this->assertInstanceOf(Project::class, auth()->user()->projects->first());
    }

    /** @test */
    public function it_has_many_teams()
    {
        $this->login();

        $project = create(Project::class);

        $project->team->members()->save(auth()->user());

        $this->assertInstanceOf(Team::class, auth()->user()->teams->first());
    }
}
