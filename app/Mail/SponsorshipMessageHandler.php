<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Mail;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\SponsorshipMessage;
use MailClient;

class SponsorshipMessageHandler
{
    /**
     * @param \App\Models\SponsorshipMessage $message
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function send(SponsorshipMessage $message)
    {
        MailClient::send([
            'to' => $message->personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => $message->messageType->subject,
            'template' => $message->messageType->template_id,
            'h:X-Mailgun-Variables' => json_encode([
                'ime_botra' => $message->personData->first_name,
                'boter_moski' => $message->personData->gender === PersonData::GENDER_MALE,
                'ime_muce' => $message->cat->name,
                'muca_moski' => $message->cat->gender === Cat::GENDER_MALE,
            ]),
        ]);
    }
}
