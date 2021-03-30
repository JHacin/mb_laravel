<?php

namespace Tests\Unit\Mail;

use App\Models\Cat;
use App\Models\PersonData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MailClient;
use SponsorshipMessageHandler;
use Tests\TestCase;

class SponsorshipMessageHandlerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

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
                'h:X-Mailgun-Variables' => json_encode([
                    'ime_botra' => $msg->personData->first_name,
                    'boter_moski' => $msg->personData->gender === PersonData::GENDER_MALE,
                    'ime_muce' => $msg->cat->name,
                    'muca_moski' => $msg->cat->gender === Cat::GENDER_MALE,
                ])
            ]);

        SponsorshipMessageHandler::send($msg);
    }

    public function test_passes_correct_male_gender_variable()
    {
        $msg = $this->createSponsorshipMessage([
            'message_type_id' => $this->createSponsorshipMessageType()->id,
            'person_data_id' => $this->createPersonData(['gender' => PersonData::GENDER_MALE])->id,
            'cat_id' =>  $this->createCat(['gender' => Cat::GENDER_MALE])->id,
        ]);

        MailClient::shouldReceive('send')
            ->once()
            ->with([
                'to' => $msg->personData->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => $msg->messageType->subject,
                'template' => $msg->messageType->template_id,
                'h:X-Mailgun-Variables' => json_encode([
                    'ime_botra' => $msg->personData->first_name,
                    'boter_moski' => true,
                    'ime_muce' => $msg->cat->name,
                    'muca_moski' => true,
                ])
            ]);

        SponsorshipMessageHandler::send($msg);
    }

    public function test_passes_correct_female_gender_variable()
    {
        $msg = $this->createSponsorshipMessage([
            'message_type_id' => $this->createSponsorshipMessageType()->id,
            'person_data_id' => $this->createPersonData(['gender' => PersonData::GENDER_FEMALE])->id,
            'cat_id' =>  $this->createCat(['gender' => Cat::GENDER_FEMALE])->id,
        ]);

        MailClient::shouldReceive('send')
            ->once()
            ->with([
                'to' => $msg->personData->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => $msg->messageType->subject,
                'template' => $msg->messageType->template_id,
                'h:X-Mailgun-Variables' => json_encode([
                    'ime_botra' => $msg->personData->first_name,
                    'boter_moski' => false,
                    'ime_muce' => $msg->cat->name,
                    'muca_moski' => false,
                ])
            ]);

        SponsorshipMessageHandler::send($msg);
    }
}
