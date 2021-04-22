<?php

namespace App\Mail;

use App\Mail\Client\MailClient;
use App\Models\PersonData;

class SponsorMailingListManager
{
    public const ALL_SPONSORS_LIST_ADDRESS = 'vsi_botri';

    protected MailClient $mailClient;

    public function __construct(MailClient $mailClient)
    {
        $this->mailClient = $mailClient;
    }

    public function addToAllLists(PersonData $sponsor)
    {
        $variables = [
            'boter_moski' => $sponsor->gender === PersonData::GENDER_MALE,
            'boter_ime' => $sponsor->first_name,
            'boter_priimek' => $sponsor->last_name,
        ];

        $this->mailClient->addMemberToList(self::ALL_SPONSORS_LIST_ADDRESS, $sponsor->email, $variables);
    }

    public function removeFromAllLists(PersonData $sponsor)
    {
        $this->mailClient->removeMemberFromList(self::ALL_SPONSORS_LIST_ADDRESS, $sponsor->email);
    }
}
