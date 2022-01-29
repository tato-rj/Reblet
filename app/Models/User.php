<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'creator_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'creator_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function unreadComments()
    {
        return $this->hasMany(UnreadComment::class);
    }

    public function read(Comment $comment)
    {
        return $this->unreadComments()->where('comment_id', $comment->id)->delete();
    }

    public function hasRead(Comment $comment)
    {
        return ! $this->unreadComments()->where('comment_id', $comment->id)->exists();
    }

    public function avatar($size = null)
    {
        return view('pages.users.avatar', ['initial' => substr($this->name, 0, 1), 'size' => $size])->render();
    }

    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
