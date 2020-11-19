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
}
