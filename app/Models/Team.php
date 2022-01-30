<?php

namespace App\Models;

class Team extends Reblet
{
    protected static function booted()
    {
        self::created(function($team) {
            $team->members()->save($team->project->creator);
        });

        self::deleting(function($team) {
            $team->members()->detach();
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

    public function orderedMembers()
    {
        if (! $this->findUser(auth()->user()))
            return $this->members;
        
        return $this->members->reject(function($member) {
            return $member->is(auth()->user());
        })->prepend(auth()->user());
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
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
