<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Project, Folder, Revision, File};

class RevisionTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->revision = create(Revision::class);
    }

    /** @test */
    public function it_belongs_to_a_folder()
    {
        $this->assertInstanceOf(Folder::class, $this->revision->folder);
    }

    /** @test */
    public function it_has_many_files()
    {
        $this->revision->files()->save(create(File::class));

        $this->assertInstanceOf(File::class, $this->revision->files->first());
    }
}
