<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Project, Folder, User, Team};

class ProjectTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->project = create(Project::class);
    }

    /** @test */
    public function it_belongs_to_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->project->creator);
    }

    /** @test */
    public function it_has_one_team()
    {
        $this->assertInstanceOf(Team::class, $this->project->team);
    }

    /** @test */
    public function it_has_many_members()
    {        
        $this->assertInstanceOf(User::class, $this->project->team->members->first());
    }

    /** @test */
    public function it_automatically_has_a_leader_when_created()
    {        
        $this->assertInstanceOf(User::class, $this->project->team->leader());
    }

    /** @test */
    public function it_automatically_has_a_home_folder_when_created()
    {
        $this->assertNotEmpty($this->project->folders()->home());
    }

    /** @test */
    public function it_has_many_folders()
    {
        $this->project->folders()->create(Folder::factory()->make()->toArray());

        $this->assertTrue($this->project->folders->count() > 1);

        $this->assertInstanceOf(Folder::class, $this->project->folders->first());
    }
}
