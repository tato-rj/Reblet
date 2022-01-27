<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Folder, Project, Revision, User, Comment};

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
    public function it_has_subfolders()
    {
        $parent = create(Folder::class);

        $folder = create(Folder::class, ['parent_type' => Folder::class, 'parent_id' => $parent->id]); 

        $this->assertInstanceOf(Folder::class, $parent->children()->first()); 
    }

    /** @test */
    public function it_knows_its_breadcrumb()
    {
        $project = create(Project::class);

        $home = $project->folders()->first();

        $grandparent = create(Folder::class, ['name' => 'grandparent', 'parent_type' => get_class($home), 'parent_id' => $home->id]);

        $parent = create(Folder::class, ['name' => 'parent', 'parent_type' => get_class($grandparent), 'parent_id' => $grandparent->id]);

        $child = create(Folder::class, ['parent_type' => get_class($parent), 'parent_id' => $parent->id]);

        $this->assertEquals($child->breadcrumb()->count(), 4);
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

    /** @test */
    public function it_has_many_comments()
    {
        $comment = create(Comment::class, ['model_type' => get_class($this->folder), 'model_id' => $this->folder->id]);

        $this->assertInstanceOf(Comment::class, $this->folder->comments->first());
    }
}
