<?php

namespace App\Mail;

use App\Models\Sponsorship;
use MailClient;

class SponsorshipMail
{
    /**
     * @param \App\Models\Sponsorship $sponsorship
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function sendInitialInstructionsEmail(Sponsorship $sponsorship)
    {
        $template = $sponsorship->payment_type === Sponsorship::PAYMENT_TYPE_BANK_TRANSFER
            ? 'navodila_za_botrovanje_nakazilo'
            : 'navodila_za_botrovanje_trajnik';

        MailClient::send([
            'to' => $sponsorship->personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'template' => $template,
        ]);
    }
}
