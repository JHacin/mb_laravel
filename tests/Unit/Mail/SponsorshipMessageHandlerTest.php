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
        $messageType = $this->createSponsorshipMessageType(['template_id' => 'prvi_pozdrav_1']);
        $personData = $this->createPersonData();
        $cat = $this->createCat();

        MailClient::shouldReceive('send')
            ->once()
            ->with([
                'to' => $personData->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => $messageType->subject,
                'template' => $messageType->template_id,
                'v:boter' => $personData->first_name,
                'v:muca' => $cat->name,
            ]);

        SponsorshipMessageHandler::send($messageType, $personData, $cat);
    }
}
