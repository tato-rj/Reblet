<?php

namespace App\Models;

class Comment extends Reblet
{
    protected static function booted()
    {
        self::created(function($comment) {
            $comment->team->members->each(function($user) use ($comment) {
                if (auth()->check() && ! $comment->user->is($user))
                    UnreadComment::create(['comment_id' => $comment->id, 'user_id' => $user->id]);
            });
        });

        self::deleting(function($comment) {
            UnreadComment::where(['comment_id' => $comment->id])->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
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

        if ($this->created_at->gte(now()->subSeconds(10)))
            return 'Just now';

        if ($this->created_at->isToday())
            return 'Today at ' . $time;

        if ($this->created_at->isYesterday())
            return 'Yesterday at ' . $time;

        return $this->created_at->format('M j') . ' at ' . $time ;
    }
}
