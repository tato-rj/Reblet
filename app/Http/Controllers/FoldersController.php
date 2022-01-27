<?php

namespace App\Http\Controllers;

use App\Models\{Folder, Project};
use Illuminate\Http\Request;

class FoldersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, Folder $folder)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'max:255'
        ]);

        Folder::create([
            'slug' => str_slug($request->name),
            'creator_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'project_id' => $project->id,
            'parent_type' => get_class($folder),
            'parent_id' => $folder->id
        ]);

        return back()->with('success', 'The folder has been successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Folder $folder)
    {
        return view('pages.folders.show', compact(['project', 'folder']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Folder $folder)
    {
        $folder->delete();

        return back()->with('success', 'The folder has been deleted.');
    }
}
