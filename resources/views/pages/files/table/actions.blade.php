<div class="d-flex justify-content-end align-items-center">
  <div class="mr-2 opacity-6 file-action-button" data-toggle="tooltip" data-bs-placement="top" title="Info">
    @btn(['icon' => ['name' => 'info-circle', 'position' => 'center'], 'attr' => 'data-action=info-'.$file->id.' data-url='.route('files.actions', ['file' => $file, 'action' => 'info']), 'theme' => 'raw'])
  </div>
  
  <div class="mr-2 opacity-6 file-action-button" data-toggle="tooltip" data-bs-placement="top" title="Share">
    @btn(['icon' => ['name' => 'share-alt', 'position' => 'center'], 'attr' => 'data-action=share-'.$file->id.' data-url='.route('files.actions', ['file' => $file, 'action' => 'share']), 'theme' => 'raw'])
  </div>

  <div class="mr-2 opacity-6 file-action-button" data-toggle="tooltip" data-bs-placement="top" title="Supporting documents">
    @btn(['icon' => ['name' => 'paperclip', 'position' => 'center'], 'attr' => 'data-action=supporting-docs-'.$file->id.' data-url='.route('files.actions', ['file' => $file, 'action' => 'supporting-docs']), 'theme' => 'raw'])
  </div>

  <div class="mr-2 opacity-6 file-action-button" data-toggle="tooltip" data-bs-placement="top" title="Comments">
    @btn(['icon' => ['name' => 'comments', 'position' => 'center'], 'attr' => 'data-action=comments-'.$file->id.' data-url='.route('files.actions', ['file' => $file, 'action' => 'comments']), 'theme' => 'raw'])
  </div>

  <div class="mr-2 opacity-6 file-action-button" data-toggle="tooltip" data-bs-placement="top" title="Edit file">
    @btn(['icon' => ['name' => 'edit', 'position' => 'center'], 'attr' => 'data-action=edit-'.$file->id.' data-url='.route('files.actions', ['file' => $file, 'action' => 'edit']), 'theme' => 'raw', 'title' => 'Edit file'])
  </div>

  @delete(['item' => 'file', 'target' => 'file-'.$file->id, 'url' => route('files.destroy', $file)])
</div>