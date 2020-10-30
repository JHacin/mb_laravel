<?php

namespace App\Observers;

use App\Models\PersonData;

class PersonDataObserver
{
    /**
     * @param PersonData $personData
     */
    protected function getEmailFromRelatedUser(PersonData $personData)
    {
        if ($personData->user) {
            $personData->update(['email' => $personData->user->email]);
        }
    }

    /**
     * Handle the person data "created" event.
     *
     * @param PersonData $personData
     * @return void
     */
    public function created(PersonData $personData)
    {
        $this->getEmailFromRelatedUser($personData);
    }

    /**
     * Handle the person data "updated" event.
     *
     * @param PersonData $personData
     * @return void
     */
    public function updated(PersonData $personData)
    {
        //
    }

    /**
     * Handle the person data "deleted" event.
     *
     * @param PersonData $personData
     * @return void
     */
    public function deleted(PersonData $personData)
    {
        //
    }

    /**
     * Handle the person data "restored" event.
     *
     * @param PersonData $personData
     * @return void
     */
    public function restored(PersonData $personData)
    {
        //
    }

    /**
     * Handle the person data "force deleted" event.
     *
     * @param PersonData $personData
     * @return void
     */
    public function forceDeleted(PersonData $personData)
    {
        //
    }
}
