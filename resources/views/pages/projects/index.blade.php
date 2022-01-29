@extends('layouts.app', ['title' => 'My Projects'])

@push('header')
@endpush

@section('content')
@container
@title(['title' => 'My projects'])

<div class="mb-4">
@if(auth()->user()->teams()->exists())
@include('pages.projects.table')
@else
<span class="text-muted">Click below to start your first project!</span>
@endif
</div>

@include('pages.projects.create')


@endcontainer
@endsection

@push('scripts')
@endpush