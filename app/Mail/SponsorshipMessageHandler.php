<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Mail;

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
            'v:ime_botra' => $message->personData->first_name,
            'v:ime_muce' => $message->cat->name,
        ]);
    }
}
