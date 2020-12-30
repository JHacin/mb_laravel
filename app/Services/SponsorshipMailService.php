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
     * @param MailClient|null $mailService
     */
    public function __construct($mailService = null)
    {
        $this->client = $mailService ?: new MailClient();
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
            'text' => 'Tukaj so navodila, ki jih boter prejme po izpolnitvi obrazca za pristop k botrstvu za eno od muc.',
        ]);
    }
}
