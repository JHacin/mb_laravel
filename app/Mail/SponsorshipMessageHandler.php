<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Mail;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\SponsorshipMessageType;
use MailClient;

class SponsorshipMessageHandler
{

    /**
     * @param \App\Models\SponsorshipMessageType $messageType
     * @param \App\Models\PersonData $personData
     * @param \App\Models\Cat $cat
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function send(SponsorshipMessageType $messageType, PersonData $personData, Cat $cat)
    {
        MailClient::send([
            'to' => $personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => $messageType->subject,
            'template' => $messageType->template_id,
            'v:boter' => $personData->first_name,
            'v:muca' => $cat->name,
        ]);
    }
}
