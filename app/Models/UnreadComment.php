<?php

namespace App\Models;

class UnreadComment extends Reblet
{
    protected $with = ['comment', 'user'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
