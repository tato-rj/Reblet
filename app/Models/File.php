<?php

namespace App\Models;

class File extends DocuSquared
{
    public function supportData()
    {
        return $this->hasMany(SupportData::class);
    }
}
