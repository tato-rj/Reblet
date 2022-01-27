<?php

namespace App\Models;

class Team extends DocuSquared
{
    protected static function booted()
    {
        self::created(function($team) {
            $team->members()->save($team->project->creator);
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function leader()
    {
        return $this->members()->where('users.id', $this->project->creator_id)->first();
    }

    public function remove(User $user)
    {
        return \DB::table('team_user')->where([
            ['user_id', '=', $user->id],
            ['team_id', '=', $this->id]
        ])->delete();
    }

    public function findUser(User $user)
    {
        return $this->members->where('email', $user->email)->first();
    }
}
