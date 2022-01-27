<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Comment, User, File, Folder};

class CommentTest extends AppTest
{
    /** @test */
    public function it_belongs_to_a_user()
    {
        $comment = create(Comment::class);

        $this->assertInstanceOf(User::class, $comment->user);
    }

    /** @test */
    public function it_can_belong_to_a_file()
    {
        $comment = create(Comment::class);

        $this->assertInstanceOf(File::class, $comment->model);
    }

    /** @test */
    public function it_can_belong_to_a_folder()
    {
        $comment = create(Comment::class, ['model_type' => Folder::class, 'model_id' => create(Folder::class)->id]);

        $this->assertInstanceOf(Folder::class, $comment->model);
    }

    /** @test */
    public function it_can_be_a_reply_to_another_comment()
    {
        $comment = create(Comment::class);

        $reply = create(Comment::class, ['parent_id' => $comment->id]);

        $this->assertInstanceOf(Comment::class, $reply->parent);  
    }

    /** @test */
    public function it_has_many_replies()
    {
        $comment = create(Comment::class);

        create(Comment::class, ['parent_id' => $comment->id]);

        $this->assertInstanceOf(Comment::class, $comment->replies->first());    
    }
}
