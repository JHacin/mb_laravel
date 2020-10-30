<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * @param User $user
     */
    protected function initializePersonData(User $user)
    {
        $user->personData()->updateOrCreate([]);
    }

    /**
     * Handle the user "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user)
    {
        $this->initializePersonData($user);
    }

    /**
     * @param User $user
     */
    protected function syncEmailWithPersonData(User $user)
    {
        if ($user->personData->email !== $user->email) {
            $user->personData->update(['email' => $user->email]);
        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user)
    {
        $this->syncEmailWithPersonData($user);
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
