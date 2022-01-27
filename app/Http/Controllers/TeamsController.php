<?php

namespace App\Http\Controllers;

use App\Models\{Team, Project, User};
use Illuminate\Http\Request;
use App\Mail\MemberInvitationEmail;

class TeamsController extends Controller
{
    public function sendInvitationEmail(Request $request, Project $project)
    {
        $request->validate(['name' => 'required', 'email' => 'email|required']);

        \Mail::to($request->email)->send(new MemberInvitationEmail($request, $project));

        return back()->with('success', 'The invitation is on the way.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request, Project $project)
    {
        if ($user = User::byEmail($request->email)->first()) {
            $project->team->members()->save($user);

            return redirect(route('projects.folders.show', ['project' => $project, 'folder' => $project->folders()->home()]));
        } else {
            return redirect(route('register'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $team = $project->team;
        
        return view('pages.team.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, Project $project)
    {
        $this->authorize('update', $project->team);

        $request->validate(['email' => 'required|email|exists:users']);

        $user = User::byEmail($request->email)->firstOrFail();

        $project->team->remove($user);

        return back()->with('success', 'The user has beem removed from the team.');
    }
}
