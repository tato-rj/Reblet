<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{User, Project, Team, Comment};

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

    /** @test */
    public function it_has_many_comments()
    {
        $this->login();

        $project = create(Project::class);

        $project->team->members()->save(auth()->user());

        $comment = create(Comment::class, ['team_id' => $project->team]);

        $this->assertInstanceOf(Comment::class, auth()->user()->teams->first()->comments()->first());
    }

    /** @test */
    public function it_has_many_unread_comments()
    {
        $this->login();

        $user = auth()->user();

        $project = create(Project::class);

        $project->team->members()->save(auth()->user());

        $this->assertEquals(auth()->user()->unreadComments()->count(), 0);

        $comment = create(Comment::class, ['team_id' => $project->team]);

        $this->assertEquals(auth()->user()->unreadComments()->count(), 1);

        $user->read($comment);

        $this->assertEquals(auth()->user()->unreadComments()->count(), 0);
    }

    /** @test */
    public function it_knows_if_it_has_read_a_comment()
    {
        $this->login();

        $project = create(Project::class);

        $project->team->members()->save(auth()->user());

        $comment = create(Comment::class, ['team_id' => $project->team]);

        $this->assertFalse(auth()->user()->hasRead($comment));
        
        auth()->user()->read($comment);

        $this->assertTrue(auth()->user()->hasRead($comment));
    }
}
