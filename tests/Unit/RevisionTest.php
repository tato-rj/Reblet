<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Project, Folder, Revision, File};
use Tests\Traits\Loggedin;

class RevisionTest extends AppTest
{
    use Loggedin;

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

    /** @test */
    public function it_knows_its_path()
    {
        $this->assertTrue(str_contains($this->revision->path(), 'revision-'));
    }
}
