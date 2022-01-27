<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Team;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('comments.{team}', function ($user, Team $team) {
    return $team->members->contains($user);
});
