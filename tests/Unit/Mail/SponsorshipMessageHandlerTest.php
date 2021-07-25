<?php

namespace Tests\Unit\Mail;

use App\Mail\Client\MailClient;
use App\Mail\SponsorshipMessageHandler;
use App\Models\Cat;
use App\Models\PersonData;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SponsorshipMessageHandlerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * @throws BindingResolutionException
     */
    public function test_sends_message_with_correct_params()
    {
        $msg = $this->createSponsorshipMessage([
            'message_type_id' => $this->createSponsorshipMessageType()->id,
            'sponsor_id' => $this->createPersonData()->id,
            'cat_id' =>  $this->createCat()->id,
        ]);

        $this->mock(MailClient::class)
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => $msg->sponsor->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => $msg->messageType->subject,
                'template' => $msg->messageType->template_id,
                'h:X-Mailgun-Variables' => json_encode([
                    'ime_botra' => $msg->sponsor->first_name,
                    'boter_moski' => $msg->sponsor->gender === PersonData::GENDER_MALE,
                    'ime_muce' => $msg->cat->name,
                    'muca_moski' => $msg->cat->gender === Cat::GENDER_MALE,
                ])
            ]);

        $this->app->make(SponsorshipMessageHandler::class)->send($msg);
    }

    /**
     * @throws BindingResolutionException
     */
    public function test_passes_correct_male_gender_variable()
    {
        $msg = $this->createSponsorshipMessage([
            'message_type_id' => $this->createSponsorshipMessageType()->id,
            'sponsor_id' => $this->createPersonData(['gender' => PersonData::GENDER_MALE])->id,
            'cat_id' =>  $this->createCat(['gender' => Cat::GENDER_MALE])->id,
        ]);

        $this->mock(MailClient::class)
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => $msg->sponsor->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => $msg->messageType->subject,
                'template' => $msg->messageType->template_id,
                'h:X-Mailgun-Variables' => json_encode([
                    'ime_botra' => $msg->sponsor->first_name,
                    'boter_moski' => true,
                    'ime_muce' => $msg->cat->name,
                    'muca_moski' => true,
                ])
            ]);

        $this->app->make(SponsorshipMessageHandler::class)->send($msg);
    }

    /**
     * @throws BindingResolutionException
     */
    public function test_passes_correct_female_gender_variable()
    {
        $msg = $this->createSponsorshipMessage([
            'message_type_id' => $this->createSponsorshipMessageType()->id,
            'sponsor_id' => $this->createPersonData(['gender' => PersonData::GENDER_FEMALE])->id,
            'cat_id' =>  $this->createCat(['gender' => Cat::GENDER_FEMALE])->id,
        ]);

        $this->mock(MailClient::class)
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => $msg->sponsor->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => $msg->messageType->subject,
                'template' => $msg->messageType->template_id,
                'h:X-Mailgun-Variables' => json_encode([
                    'ime_botra' => $msg->sponsor->first_name,
                    'boter_moski' => false,
                    'ime_muce' => $msg->cat->name,
                    'muca_moski' => false,
                ])
            ]);

        $this->app->make(SponsorshipMessageHandler::class)->send($msg);
    }
}
