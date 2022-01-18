<?php

namespace App\Models;

class Folder extends DocuSquared
{
    protected static function booted()
    {
        self::created(function($folder) {
            $folder->revisions()->create();
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

    public function scopeRoot($query)
    {
        return $query->whereNull('name')->first();
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
}
