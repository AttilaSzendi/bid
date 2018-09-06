<?php

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


// the private chanel needs logged in users
Broadcast::channel('bid-channel.{id}', function ($user, $id) {
    if($user->id === 3) {
        return false;
    }

    return true;
});
