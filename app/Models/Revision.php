<?php

namespace App\Models;

class Revision extends DocuSquared
{
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
