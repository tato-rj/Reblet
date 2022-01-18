<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Folder, Project, Revision, User};

class FolderTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->folder = create(Folder::class);
    }

    /** @test */
    public function it_belongs_to_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->folder->creator);
    }

    /** @test */
    public function it_can_belong_to_a_project()
    {
        $this->assertInstanceOf(Project::class, $this->folder->parent);
    }

    /** @test */
    public function it_can_belong_to_another_folder()
    {
        $folder = create(Folder::class, ['parent_type' => Folder::class, 'parent_id' => create(Folder::class)->id]); 

        $this->assertInstanceOf(Folder::class, $folder->parent); 
    }

    /** @test */
    public function it_automatically_has_a_revision_when_created()
    {
        $this->assertNotEmpty($this->folder->revisions);
    }

    /** @test */
    public function it_has_many_revisions()
    {
        $this->folder->revisions()->create();

        $this->assertTrue($this->folder->revisions()->count() > 1);

        $this->assertInstanceOf(Revision::class, $this->folder->revisions->first());
    }

    /** @test */
    public function new_folders_need_approval_from_the_project_creator()
    {
        $this->assertFalse($this->folder->isApproved());

        $this->folder->approve();

        $this->assertTrue($this->folder->isApproved());
    }
}
