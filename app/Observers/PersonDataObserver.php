<?php

namespace App\Observers;

use App\Mail\SponsorMailingListManager;
use App\Models\PersonData;

class PersonDataObserver
{
    private SponsorMailingListManager $mailingListManager;

    public function __construct(SponsorMailingListManager $mailingListManager)
    {
        $this->mailingListManager = $mailingListManager;
    }

    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */

    public function created(PersonData $personData)
    {
        $this->getEmailFromRelatedUser($personData);
        $this->mailingListManager->addToAllLists($personData);
    }

    public function updated(PersonData $personData)
    {
        if ($personData->user) {
            $this->syncEmailWithUser($personData);
        }
    }

    public function deleted(PersonData $personData)
    {
        $this->mailingListManager->removeFromAllLists($personData);
    }

    /*
    |--------------------------------------------------------------------------
    | METHODS
    |--------------------------------------------------------------------------
    */

    protected function getEmailFromRelatedUser(PersonData $personData)
    {
        if ($personData->user) {
            $personData->update(['email' => $personData->user->email]);
        }
    }

    protected function syncEmailWithUser(PersonData $personData)
    {
        if ($personData->user->email !== $personData->email) {
            $personData->user->update(['email' => $personData->email]);
        }
    }
}
