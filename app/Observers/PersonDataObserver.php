<?php

namespace App\Observers;

use App\Models\PersonData;

class PersonDataObserver
{
    /**
     * @param PersonData $personData
     * @return void
     */
    public function created(PersonData $personData)
    {
        $this->getEmailFromRelatedUser($personData);
    }

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
     * @param PersonData $personData
     * @return void
     */
    public function updated(PersonData $personData)
    {
        if ($personData->user) {
            $this->syncEmailWithUser($personData);
        }
    }

    /**
     * @param PersonData $personData
     */
    protected function syncEmailWithUser(PersonData $personData)
    {
        if ($personData->user->email !== $personData->email) {
            $personData->user->update(['email' => $personData->email]);
        }
    }
}
