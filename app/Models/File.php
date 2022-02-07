<?php

namespace App\Models;

use App\Models\Traits\Commentable;

class File extends Reblet
{    
    use Commentable;
    
    protected $dates = ['replaced_at', 'downloaded_at'];

    protected static function booted()
    {
        self::deleting(function($file) {
            aws()->disk()->delete($file->path);
            $file->supportData->each->delete();
            $file->comments->each->delete();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    
    public function revision()
    {
        return $this->belongsTo(Revision::class);
    }
    
    public function duplicatedFrom()
    {
        return $this->belongsTo(Revision::class, 'duplicated_from_revision_id');
    }

    public function supportData()
    {
        return $this->hasMany(SupportData::class);
    }

    public function scopeByUrl($query, $path)
    {
        return $query->where('url', $path)->first();
    }

    public function scopeByName($query, $filename)
    {
        return $query->where('name', $filename)->first();
    }

    public function scopeGenerateName($scope, $name)
    {
        $ext = getExtension($name);

        return uuid() .'.'. $ext;
    }

    public function getProjectName()
    {
        $project = $this->revision->folder->project;

        return ucfirst(str_slug($project->name));   
    }

    public function getRevisionName()
    {
        $revision = $this->revision;

        return ucfirst(str_replace('revision', 'rev', $revision->name));
    }

    public function getFolderTag()
    {
        return str_slug($this->revision->folder->tag);
    }

    public function getOrder()
    {
        $order = $this->revision->files()->whereNull('custom_name')->get()->search(function($file, $index) {
            return $file->is($this);
        });

        return sprintf('%02d', $order += 1);
    }

    public function publicName($ext = false)
    {
        $extension = $ext ? '.' . $this->extension : null;

        if ($this->custom_name)
            return $this->custom_name . $extension;

        $pieces = array_filter([
            $this->getProjectName(), 
            $this->getFolderTag(), 
            $this->getOrder(),
            $this->getRevisionName()]);
        
        return implode('-', $pieces) . $extension;
    }

    public function getFormattedSizeAttribute()
    {
        $units = ['bytes', 'kb', 'mb', 'gb', 'tb'];

        $power = floor(log($this->size, 1024));

        return number_format($this->size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    public function unused()
    {
        return ! $this->replaced_at && $this->duplicatedFrom()->exists();
    }

    public function route($params = [])
    {
        return $this->revision->folder->route($params);
    }
}

