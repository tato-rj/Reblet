<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{File, SupportData};

class FileTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->file = create(File::class);
    }

    /** @test */
    public function it_has_many_supporting_data()
    {
        $this->file->supportData()->save(create(SupportData::class));

        $this->assertInstanceOf(SupportData::class, $this->file->supportData->first());
    }
}
