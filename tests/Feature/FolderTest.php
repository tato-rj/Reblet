<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Folder, Project};
use Tests\Traits\Loggedin;

class FolderTest extends AppTest
{
    use Loggedin;

    /** @test */
    public function users_can_create_a_new_folder()
    {
        $project = create(Project::class, ['creator_id' => auth()->user()->id]);

        $request = make(Folder::class, ['project_id' => $project->id]);

        $this->post(route('projects.folders.store', ['project' => $request->project, 'folder' => $request->project->folders()->home()]), [
            'name' => $request->name,
            'tag' => $request->tag,
            'description' => $request->description
        ]);

        $this->assertDatabaseHas('folders', ['name' => $request->name]);
    }

    /** @test */
    public function users_can_delete_a_folder()
    {
        $project = create(Project::class, ['creator_id' => auth()->user()->id]);

        $folder = create(Folder::class, ['project_id' => $project->id]);

        $this->delete(route('projects.folders.destroy', ['project' => $folder->project, 'folder' => $folder]));

        $this->assertDatabaseMissing('folders', ['name' => $folder->name]);
    }

    /** @test */
    public function a_folders_subfolders_and_revisions_are_deleted_along_with_it()
    {
        $project = create(Project::class, ['creator_id' => auth()->user()->id]);

        $folder = create(Folder::class, ['project_id' => $project->id]);

        $revision = $folder->revisions->first();

        $subfolder = create(Folder::class, ['project_id' => $folder->project->id, 'parent_type' => get_class($folder), 'parent_id' => $folder->id]);

        $this->delete(route('projects.folders.destroy', ['project' => $folder->project, 'folder' => $folder]));

        $this->assertDatabaseMissing('folders', ['name' => $folder->name]);
        
        $this->assertDatabaseMissing('folders', ['name' => $subfolder->name]);

        $this->assertDatabaseMissing('revisions', ['id' => $revision->id]);
    }
}
