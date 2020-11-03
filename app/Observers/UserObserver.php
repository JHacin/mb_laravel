<?php

namespace App\Observers;

use App\Models\PersonData;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user)
    {
        $this->createOrAssociatePersonData($user);
    }

    /**
     * @param User $user
     */
    protected function createOrAssociatePersonData(User $user)
    {
        $connectedPersonData = PersonData::firstWhere('email', $user->email);

        if ($connectedPersonData instanceof PersonData) {
            $connectedPersonData->user()->associate($user);
            $connectedPersonData->save();
        } else {
            $user->personData()->updateOrCreate([]);
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
     * @param User $user
     */
    protected function syncEmailWithPersonData(User $user)
    {
        if ($user->personData->email !== $user->email) {
            $user->personData->update(['email' => $user->email]);
        }
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
}
