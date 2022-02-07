<?php

namespace App\Models;

class Revision extends Reblet
{
    protected static function booted()
    {
        self::creating(function($revision) {
            $revision->name = $revision->generateName();
        });

        self::created(function($revision) {
            if ($revision->siblings()->exists())
                $revision->previous()->copyFilesTo($revision);
        });

        self::deleting(function($revision) {
            $revision->files->each->delete();
        });
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function path()
    {
        $path = 'files' . parse_url($this->folder->route())['path'] . '/' . $this->name;

        return $path;
    }

    public function getFormattedNameAttribute()
    {
        return ucfirst(str_replace('-', ' ', $this->name));
    }

    public function generateName()
    {
        $lastRevision = $this->folder->revisions->last();
        $count = 0;

        if ($lastRevision)
            $count = abs((int)filter_var($lastRevision->name, FILTER_SANITIZE_NUMBER_INT));

        return 'revision-' . $count += 1;
    }

    public function siblings()
    {
        return $this->folder->revisions()->except($this->id);
    }

    public function previous()
    {
        return $this->siblings()->last();   
    }

    public function copyFilesTo($revision)
    {
        $this->files->each(function($file) use ($revision) {
            $newName = File::generateName($file->name);
            
            $newPath = $revision->path() . '/' . $newName;

            aws()->disk()->copy($file->path, $newPath);

            $file->replicate()->fill([
                'url' => aws()->disk()->url($newPath),
                'path' => $newPath,
                'name' => $newName,
                'revision_id' => $revision->id,
                'duplicated_from_revision_id' => $file->revision_id,
                'replaced_at' => null
            ])->save();

            $newFile = File::byName($newName);

            $file->supportData->each(function($supportFile) use ($newFile) {
                $supportFile->replicate()->fill([
                    'file_id' => $newFile->id
                ])->save();
            });
        });
    }

    public function duplicateFile($name)
    {
        $downloaded = $this->files()->where('downloaded_name', $name)->first();

        return $downloaded ?? $this->files()->where('original_name', removeExtension($name))->first();
    }
}
