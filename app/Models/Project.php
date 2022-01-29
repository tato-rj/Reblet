<?php

namespace App\Models;

use App\Models\Traits\FindBySlug;

class Project extends Reblet
{
    use FindBySlug;

    protected $with = ['folders'];

    protected static function booted()
    {
        self::created(function($project) {
            $project->folders()->create([
                'slug' => 'home',
                'name' => 'Home',
                'project_id' => $project->id,
                'creator_id' => $project->creator_id,
                'is_home' => true
            ]);

            $project->team()->save(new Team(['name' => $project->name . ' team']));
        });

        self::deleting(function($project) {
            $project->folders->each->delete();
            $project->team->delete();
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

    public function route()
    {
        return route('projects.show', $this);
    }
}
