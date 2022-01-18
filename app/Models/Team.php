<?php

namespace App\Models;

class Team extends DocuSquared
{
    public function members()
    {
        return $this->belongsToMany(User::class);
    }
}
