<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Folder, File, Comment};
use Illuminate\Http\UploadedFile;
use Tests\Traits\Loggedin;

class CommentTest extends AppTest
{
    use Loggedin;

    /** @test */
    public function users_can_write_comments()
    {
        $file = create(File::class);

        $this->post(route('comments.store'), ['content' => 'foo', 'model_type' => get_class($file), 'model_id' => $file->id]);

        $this->assertDatabaseHas('comments', ['content' => 'foo']);
    }

    /** @test */
    public function users_can_delete_their_own_comment()
    {
        $folder = create(Folder::class);

        $this->post(route('comments.store'), ['content' => 'foo', 'model_type' => get_class($folder), 'model_id' => $folder->id]);

        $this->assertDatabaseHas('comments', ['content' => 'foo']);

        $comment = Comment::first();

        $this->delete(route('comments.destroy', $comment));

        $this->assertDatabaseMissing('comments', ['content' => 'foo']);
    }

    /** @test */
    public function users_cannot_delete_others_comments()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        
        $comment = create(Comment::class);

        $this->delete(route('comments.destroy', $comment));

        $this->assertDatabaseMissing('comments', ['content' => 'foo']);
    }
}
