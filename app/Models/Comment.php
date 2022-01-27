<?php

namespace App\Models;

class Comment extends DocuSquared
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function getDateAttribute()
    {
        $time = $this->created_at->format('g:i A');

        if ($this->created_at->isToday())
            return 'Today at ' . $time;

        if ($this->created_at->isYesterdat())
            return 'Yesterday at ' . $time;

        return $this->created_at->format('M j') . ' at ' . $time ;
    }
}
