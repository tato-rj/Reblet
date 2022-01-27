<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Project, File, Revision};
use Tests\Traits\Loggedin;

class RevisionTest extends AppTest
{
    use Loggedin;

    /** @test */
    public function users_can_start_a_new_revision()
    {
        auth()->user()->projects()->create(make(Project::class)->toArray());
        
        $project = auth()->user()->projects->first();

        $this->assertEquals($project->folders->first()->revisions->count(), 1);

        $this->post(route('revisions.increment', $project->folders->first()));

        $this->assertEquals($project->folders->fresh()->first()->revisions->count(), 2);
    }

    /** @test */
    public function users_cannot_delete_a_revision_unless_there_is_more_than_one()
    {
        auth()->user()->projects()->create(make(Project::class)->toArray());
        
        $project = auth()->user()->projects->first();

        $project->folders->first()->revisions()->create();

        $this->assertEquals($project->folders->first()->revisions->count(), 2);

        $this->delete(route('revisions.destroy', $project->folders->first()->revisions->first()));

        $this->assertEquals($project->folders->fresh()->first()->revisions->count(), 1);

        $this->delete(route('revisions.destroy', $project->folders->fresh()->first()->revisions->first()));

        $this->assertEquals($project->folders->fresh()->first()->revisions->count(), 1);
    }

    /** @test */
    public function all_files_in_a_revision_are_deleted_along_with_it()
    {
        auth()->user()->projects()->create(make(Project::class)->toArray());
        
        $revision = create(Revision::class, ['folder_id' => auth()->user()->projects->first()->folders()->first()->id]);

        $file = create(File::class, ['revision_id' => $revision->id]);

        $this->delete(route('revisions.destroy', $revision));

        $this->assertDatabaseMissing('files', ['url' => $file->url]);
    }
}
