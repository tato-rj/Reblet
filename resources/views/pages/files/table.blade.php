<div class="table-responsive">
  <table class="table table-hover mb-4">
    <thead>
      <tr>
        <th></th>
        <th scope="col">File</th>
        <th scope="col">Last updated</th>
        <th scope="col">Type</th>
        <th scope="col">Size</th>
        <th scope="col" class="text-right">Actions</th>
      </tr>
    </thead>
    <tbody>
    	@foreach($revision->files as $file)
      <tr>
        <td style="width: 0">
          <input class="form-check-input" name="selected_files[]" type="checkbox" value="{{$file->id}}">
        </td>

        <td class="align-baseline text-truncate" style="max-width: 320px;" title="{{$file->publicName(true)}}">
          @include('pages.files.table.name')
        </td>

        <td class="align-baseline text-truncate">
          @include('pages.files.table.date')
        </td>

        <td class="align-baseline text-truncate">
          @include('pages.files.table.type')
        </td>

        <td class="align-baseline text-truncate">
          @include('pages.files.table.size')
        </td>

        <td class="align-baseline">
          @include('pages.files.table.actions')
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>