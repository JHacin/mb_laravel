<?php

namespace App\Mail;

use App\Models\PersonData;
use MailClient;

class SponsorshipMail
{
    /**
     * @param \App\Models\PersonData $personData
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function sendInitialInstructionsEmail(PersonData $personData)
    {
        MailClient::send([
            'to' => $personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'template' => 'sponsorship_initial_instructions',
        ]);
    }
}
