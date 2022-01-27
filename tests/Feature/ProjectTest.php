<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Project, User};
use Tests\Traits\Loggedin;

class ProjectTest extends AppTest
{
    use Loggedin;

    /** @test */
    public function users_can_create_a_new_project()
    {
        $request = make(Project::class);

        $this->post(route('projects.store'), [
            'name' => $request->name,
            'description' => $request->description
        ]);

        $this->assertDatabaseHas('projects', ['name' => $request->name]);
    }

    /** @test */
    public function users_can_delete_their_project()
    {
        auth()->user()->projects()->create(make(Project::class)->toArray());

        $project = auth()->user()->projects->first();

        $this->delete(route('projects.destroy', $project));

        $this->assertDatabaseMissing('projects', ['name' => $project->name]);
    }

    /** @test */
    public function non_leaders_cannot_delete_the_project()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        
        auth()->user()->projects()->create(make(Project::class)->toArray());

        $project = auth()->user()->projects->first();

        $member = create(User::class);

        $project->team->members()->save($member);

        $this->login($member);

        $this->delete(route('projects.destroy', $project));
    }

    /** @test */
    public function a_projects_folders_and_team_are_deleted_along_with_it()
    {
        auth()->user()->projects()->create(make(Project::class)->toArray());

        $project = auth()->user()->projects->first();

        $folder = $project->folders->first();

        $team = $project->team;

        $this->delete(route('projects.destroy', $project));

        $this->assertDatabaseMissing('folders', ['name' => $folder->name]);

        $this->assertDatabaseMissing('teams', ['name' => $team->name]);
    }

    /** @test */
    public function users_can_view_their_own_projects()
    {
        $request = make(Project::class);

        $this->post(route('projects.store'), [
            'name' => $request->name,
            'description' => $request->description
        ]);

        $project = auth()->user()->projects->first();

        $this->get(route('projects.folders.show', ['project' => $project, 'folder' => $project->folders()->home()]))
             ->assertSee($project->name);
    }

    /** @test */
    public function non_members_cannot_view_a_project()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');

        $project = create(Project::class);

        $nonmember = create(User::class);

        $this->get(route('projects.folders.show', ['project' => $project, 'folder' => $project->folders()->home()]));
    }
}
