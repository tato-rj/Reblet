<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class DocuSquared extends Model
{
	use HasFactory;
	
    protected $guarded = [];

    public function modelname()
    {
    	$array = explode('\\', get_class($this));

    	return end($array);
    }

    public function scopeLast($query)
    {
        return $query->latest('id')->first();
    }

    public function scopeExcept($query, $id)
    {
        return $query->where('id', '!=', $id);
    }
}