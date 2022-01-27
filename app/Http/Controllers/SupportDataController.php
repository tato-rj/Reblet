<?php

namespace App\Http\Controllers;

use App\Models\{SupportData, File};
use Illuminate\Http\Request;

class SupportDataController extends Controller
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
    public function store(Request $request, File $file)
    {
        $request->validate(['type' => 'required']);

        $file->supportData()->create([
            'type' => $request->type,
            'url' => $request->url,
            'data' => $request->data
        ]);

        return back()->with('success', 'The supporting file has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupportData  $supportData
     * @return \Illuminate\Http\Response
     */
    public function show(SupportData $supportData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupportData  $supportData
     * @return \Illuminate\Http\Response
     */
    public function edit(SupportData $supportData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupportData  $supportData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupportData $supportData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupportData  $supportData
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file, SupportData $supportData)
    {
        $supportData->delete();

        return back()->with('success', 'The support file has been deleted.');
    }
}
