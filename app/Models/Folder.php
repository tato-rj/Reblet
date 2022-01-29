<?php

namespace App\Models;

use App\Models\Traits\{FindBySlug, Commentable};

class Folder extends Reblet
{
    use FindBySlug, Commentable;

    protected $casts = ['is_home' => 'boolean'];

    protected static function booted()
    {
        self::created(function($folder) {
            $folder->revisions()->create();
        });

        self::deleting(function($folder) {
            $folder->children->each->delete();
            $folder->revisions->each->delete();
            $folder->comments->each->delete();
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->morphTo();
    }

    public function children()
    {
        return $this->morphMany(Folder::class, 'parent');
    }

    public function scopeHome($query)
    {
        return $query->where('slug', 'home')->first();
    }

    public function isHome()
    {
        return $this->slug == 'home';
    }

    public function breadcrumb()
    {
        $parent = $this->parent;
        $family = collect();

        while ($parent) {
            $family->prepend([
                'type' => $parent->modelname(), 
                'name' => $parent->name,
                'url' => $parent->route()
            ]);

            $parent = $parent->parent;
        }

        return $family;
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }

    public function isApproved()
    {
        return (bool) $this->approved_at;
    }

    public function approve()
    {
        return $this->update(['approved_at' => now()]);
    }

    public function route($params = [])
    {
        return route('projects.folders.show', array_merge(['project' => $this->project, 'folder' => $this], $params));
    }
}
