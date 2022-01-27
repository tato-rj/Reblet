<?php

namespace App\Http\Controllers;

use App\Models\{Comment, Project};
use App\Models\Chat\Commentable;
use Illuminate\Http\Request;
use App\Events\NewCommentPosted;

class CommentsController extends Controller
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
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'content' => 'required',
            'model_type' => 'required|string',
            'model_id' => 'required|integer'
        ]);

        $model = (new $request->model_type)->findOrFail($request->model_id);

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'team_id' => $project->team->id,
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'content' => $request->content
        ]);

        NewCommentPosted::dispatch($comment);

        return view('pages.comments.all', ['comments' => $model->comments]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $comment = Comment::findOrFail($request->id);

        return view('pages.comments.comment', compact('comment'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        return back()->with('success', 'The comment has been deleted.');
    }
}
