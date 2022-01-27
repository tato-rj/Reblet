<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Folder, File, Comment, Team, Project};
use Illuminate\Http\UploadedFile;

class CommentTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->login();

        \Event::fake();
    }

    /** @test */
    public function users_can_write_comments()
    {      
        $file = create(File::class);

        $project = $file->revision->folder->project;

        $project->team()->save(new Team(['name' => $project->name . ' team']));

        $this->post(route('comments.store', $project), ['content' => 'foo', 'model_type' => get_class($file), 'model_id' => $file->id]);

        $this->assertDatabaseHas('comments', ['content' => 'foo']);
    }

    /** @test */
    public function users_can_delete_their_own_comment()
    {
        $folder = create(Folder::class);

        $project = $folder->project;

        $project->team()->save(new Team(['name' => $project->name . ' team']));

        $this->post(route('comments.store', $project), ['content' => 'foo', 'model_type' => get_class($folder), 'model_id' => $folder->id]);

        $this->assertDatabaseHas('comments', ['content' => 'foo']);

        $comment = Comment::first();

        $this->delete(route('comments.destroy', $comment));

        $this->assertDatabaseMissing('comments', ['content' => 'foo']);
    }

    /** @test */
    public function users_cannot_delete_others_comments()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $project = create(Project::class);

        $project->team()->save(new Team(['name' => $project->name . ' team']));

        $comment = create(Comment::class, ['team_id' => $project->team]);

        $this->delete(route('comments.destroy', $comment));

        $this->assertDatabaseMissing('comments', ['content' => 'foo']);
    }
}
