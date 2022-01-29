<?php

namespace App\Storage\Providers;

class AWS
{
	protected $disk;

	public function __construct()
	{
		$this->disk = \Storage::disk('s3');
	}

	public function disk()
	{
		return $this->disk;
	}

	public function presignedUrl($filename, $minutes = 1)
	{
        $client = $this->disk->getDriver()->getAdapter()->getClient();
        $expiry = now()->addMinutes($minutes);

        $cmd = $client->getCommand('PutObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key' => $filename,
            'ACL' => 'public-read',
        ]);

        $request = $client->createPresignedRequest($cmd, $expiry);

        return (string) $request->getUri();
	}

	public function filesIn($folder)
	{
        $files = collect();

        foreach($this->disk->files($folder) as $file) {
            $files->push([
                'name' => $file, 
                'type' => $this->disk->mimeType($file),
                'size' => $this->disk->size($file), 
                'path' => $this->disk->path($file),
                'url' => $this->disk->url($file),
                'date' => $this->disk->lastModified($file)]);
        }
        
        return $files->sortBy(function($file) {
            return $file['date'];
        })->values()->all();
	}
}