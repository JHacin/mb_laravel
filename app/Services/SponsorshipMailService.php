<?php

namespace App\Services;

use App\Mail\MailClient;
use App\Models\PersonData;

class SponsorshipMailService
{
    /**
     * @var MailClient
     */
    private MailClient $client;

    /**
     * @param MailClient $mailClient
     */
    public function __construct(MailClient $mailClient)
    {
        $this->client = $mailClient;
    }

    /**
     * @param PersonData $personData
     */
    public function sendInitialInstructionsEmail(PersonData $personData)
    {
        $this->client->send([
            'to' => $personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'template' => 'sponsorship_initial_instructions',
        ]);
    }
}
