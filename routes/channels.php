<?php

use Illuminate\Support\Facades\Broadcast;

// Private channel for user-to-user messaging
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Private channel for intranet messaging
Broadcast::channel('intranet.messages.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Presence channel for intranet (who is online)
Broadcast::channel('intranet.presence', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});
