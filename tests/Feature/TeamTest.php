<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Team, Project, User};
use Tests\Traits\Loggedin;
use App\Mail\MemberInvitationEmail;

class TeamTest extends AppTest
{
    use Loggedin;

    /** @test */
    public function the_leader_of_a_team_can_invite_new_members()
    {
        \Mail::fake();

        $project = create(Project::class, ['creator_id' => auth()->user()->id]);

        $this->post(route('projects.team.invite', $project), ['name' => 'John Doe', 'email' => 'doe@email.com']);

        \Mail::assertSent(MemberInvitationEmail::class);
    }

    /** @test */
    public function the_leader_can_remove_a_member_from_a_team()
    {
        $project = create(Project::class, ['creator_id' => auth()->user()->id]);

        $user = create(User::class);

        $this->get(route('projects.team.join', ['project' => $project, 'email' => $user->email]));

        $this->delete(route('projects.team.remove', $project), ['email' => $user->email]);

        $this->assertEquals($project->team->members()->count(), 1);
    }

    /** @test */
    public function non_leaders_cannot_remove_other_members()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $project = create(Project::class, ['creator_id' => auth()->user()->id]);

        $user = create(User::class);

        $this->get(route('projects.team.join', ['project' => $project, 'email' => $user->email]));

        $this->login($user);

        $this->delete(route('projects.team.remove', $project), ['email' => $user->email]);
    }
}
