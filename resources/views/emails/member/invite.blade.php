@component('mail::message')
# Hello {{$name}}

{{$project->team->leader()->name}} invited you to join {{$project->name}}. Click on the button below to start working now.

@component('mail::button', ['url' => route('projects.team.join', ['project' => $project, 'email' => $email])])
Join the {{$project->name}} team
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
