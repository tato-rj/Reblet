<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{File, SupportData, User, Comment};

class FileTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->file = create(File::class);
    }

    /** @test */
    public function it_belongs_to_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->file->creator);
    }

    /** @test */
    public function it_has_many_supporting_data()
    {
        $this->file->supportData()->save(create(SupportData::class));

        $this->assertInstanceOf(SupportData::class, $this->file->supportData->first());
    }

    /** @test */
    public function it_has_many_comments()
    {
        $comment = create(Comment::class, ['model_type' => get_class($this->file), 'model_id' => $this->file->id]);

        $this->assertInstanceOf(Comment::class, $this->file->comments->first());
    }
}
