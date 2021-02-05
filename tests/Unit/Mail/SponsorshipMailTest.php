<?php

namespace Tests\Unit\Mail;

use App\Models\Sponsorship;
use MailClient;
use SponsorshipMail;
use Tests\TestCase;

class SponsorshipMailTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_initial_instructions_email_with_correct_params()
    {
        $sponsorship = $this->createSponsorship(['payment_type' => Sponsorship::PAYMENT_TYPE_BANK_TRANSFER]);

        $baseParams = [
            'to' => $sponsorship->personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
        ];

        MailClient::shouldReceive('send')
            ->once()
            ->with(array_merge($baseParams, ['template' => 'navodila_za_botrovanje_nakazilo']));
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);

        MailClient::shouldReceive('send')
            ->once()
            ->with(array_merge($baseParams, ['template' => 'navodila_za_botrovanje_trajnik']));
        $sponsorship->update(['payment_type' => Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT]);
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);
    }
}
