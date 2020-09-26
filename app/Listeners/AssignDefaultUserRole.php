<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\User;

class AssignDefaultUserRole
{
    /**
     * Handle the event.
     *
     * @param UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $event->user->assignRole(User::ROLE_AUTHENTICATED);
    }
}
