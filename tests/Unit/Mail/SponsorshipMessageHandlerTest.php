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
                'v:ime_botra' => $msg->personData->first_name,
                'v:spol_botra' => $msg->personData->gender === PersonData::GENDER_MALE ? 'M' : 'F',
                'v:ime_muce' => $msg->cat->name,
                'v:spol_muce' => $msg->cat->gender === Cat::GENDER_MALE ? 'M' : 'F',
            ]);

        SponsorshipMessageHandler::send($msg);
    }

    public function test_passes_correct_male_gender_abbreviation()
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
                'v:ime_botra' => $msg->personData->first_name,
                'v:spol_botra' => 'M',
                'v:ime_muce' => $msg->cat->name,
                'v:spol_muce' => 'M',
            ]);

        SponsorshipMessageHandler::send($msg);
    }

    public function test_passes_correct_female_gender_abbreviation()
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
                'v:ime_botra' => $msg->personData->first_name,
                'v:spol_botra' => 'F',
                'v:ime_muce' => $msg->cat->name,
                'v:spol_muce' => 'F',
            ]);

        SponsorshipMessageHandler::send($msg);
    }
}
