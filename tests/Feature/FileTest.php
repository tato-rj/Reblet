<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Folder, Revision, File, SupportData};
use Illuminate\Http\UploadedFile;
use Tests\Traits\Loggedin;

class FileTest extends AppTest
{
    use Loggedin;

    /** @test */
    public function users_can_save_a_new_file_in_the_database()
    {
        $revision = create(Revision::class);

        $request = make(File::class, [
            'revision_id' => $revision->id,
        ]);

        $this->post(route('files.store', $revision), $request->toArray());

        $this->assertDatabaseHas('files', ['path' => $request->path]);
    }

    /** @test */
    public function users_can_add_a_link_as_support_file_to_a_file()
    {
        $file = create(File::class);

        $request = make(SupportData::class, ['file_id' => $file->id]);

        $this->assertEquals($file->supportData()->count(), 0);

        $this->post(route('files.support-data.store', $file), $request->toArray());

        $this->assertDatabaseHas('support_data', ['url' => $request->url]);

        $this->assertEquals($file->supportData()->count(), 1);
    }

    /** @test */
    public function uses_can_delete_a_support_file()
    {
        $file = create(File::class);

        $supportFile = create(SupportData::class, ['file_id' => $file->id]);

        $this->assertEquals($file->supportData()->count(), 1);

        $this->delete(route('files.support-data.destroy', ['file' => $file, 'supportData' => $supportFile]));

        $this->assertEquals($file->supportData()->count(), 0);
    }
}
