<?php

namespace Tests\Unit\Mail;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MailClient;
use SponsorshipMessageHandler;
use Tests\TestCase;

class SponsorshipMessageHandlerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected bool $seed = true;

    /**
     * @return void
     */
    public function test_sends_message_with_correct_params()
    {

        $msg = $this->createSponsorshipMessage([
            'message_type_id' => $this->createSponsorshipMessageType()->id,
            'person_data_id' => $this->createPersonData()->id,
            'cat_id' =>  $this->createCat()->id,
        ]);

        MailClient::shouldReceive('send')
            ->once()
            ->with([
                'to' => $msg->personData->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => $msg->messageType->subject,
                'template' => $msg->messageType->template_id,
                'v:ime_botra' => $msg->personData->first_name,
                'v:ime_muce' => $msg->cat->name,
            ]);

        SponsorshipMessageHandler::send($msg);
    }
}
