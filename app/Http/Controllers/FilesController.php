<?php

namespace App\Http\Controllers;

use App\Models\{File, Revision};
use Illuminate\Http\Request;

class FilesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(Revision $revision)
    {
        $urls = array_column(aws()->filesIn($revision->path()), 'url');

        return File::whereIn('url', $urls)->get();
    }

    public function actions(Request $request, File $file)
    {
        return view('pages.files.panel.'.$request->action, compact('file'))->render();
    }

    public function presignedUrl(Request $request)
    {
        $name = File::generateName($request->name);

        $path = $request->path .'/'. $name;

        $url = aws()->presignedUrl($path);

        return response()->json([
            'name' => $name,
            'path' => $path,
            'url' => $url
        ]);
    }

    public function dropzone(Revision $revision)
    {
        return view('components.dropzone', compact('revision'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Revision $revision)
    {
        $request->validate([
            'name' => 'required',
            'path' => 'required',
            'size' => 'required'
        ]);

        if ($existingFile = $revision->duplicateFile($request->original_name)) {
            
            aws()->disk()->delete($existingFile->path);

            $existingFile->update([
                'name' => $request->name,
                'path' => $request->path,
                'size' => $request->size,
                'replaced_at' => now()
            ]);
        } else {
            auth()->user()->files()->create([
                'name' => $request->name,
                'original_name' => $request->original_name,
                'path' => $request->path,
                'type' => getExtension($request->name),
                'size' => $request->size,
                'url' => aws()->disk()->url($request->path),
                'extension' => getExtension($request->name),
                'revision_id' => $revision->id
            ]);
        }

        return view('pages.files.table', compact('revision'))->render();
    }

    public function download(File $file)
    {
        $publicName = $file->publicName(true);
        
        $file->update([
            'downloaded_name' => $publicName,
            'downloaded_at' => now()
        ]);

        return aws()->disk()->download($file->path, $publicName);
    }

    public function exists(Request $request, Revision $revision)
    {
        return $revision->duplicateFile($request->name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        $file->update([
            'custom_name' => $request->custom_name,
            'description' => $request->description
        ]);

        return back()->with('success', 'The file has been updated.');
    }

    public function destroy(Request $request, File $file)
    {
        $file->delete();

        return back()->with('success', 'The file has been successfully deleted.');
    }
}
