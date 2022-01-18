<?php

namespace App\Models;

class Project extends DocuSquared
{
    protected static function booted()
    {
        self::created(function($project) {
            $project->folders()->create(['project_id' => $project->id]);
            $project->team()->save(new Team);
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function members()
    {
        return $this->hasManyThrough(User::class, Team::class);
    }
    
    public function folders()
    {
        return $this->morphMany(Folder::class, 'parent');
    }
}
