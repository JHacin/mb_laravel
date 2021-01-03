<?php

namespace Tests\Unit\Mail;

use MailClient;
use SponsorshipMail;
use Tests\TestCase;

class SponsorshipMailTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_initial_instructions_email()
    {
        $personData = $this->createPersonData();

        MailClient::shouldReceive('send')
            ->once()
            ->with([
                'to' => $personData->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
                'template' => 'sponsorship_initial_instructions',
            ]);

        SponsorshipMail::sendInitialInstructionsEmail($personData);
    }
}
