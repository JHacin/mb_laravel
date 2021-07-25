<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Mail\MailTemplateParser;
use SponsorshipMessageHandler;
use TemplateApiClient;
use Tests\TestCase;

class SponsorshipMessageCrudControllerTest extends TestCase
{
    public function test_sends_email_on_submit_if_should_send_email_field_is_true()
    {
        SponsorshipMessageHandler::partialMock()
            ->shouldReceive('send')
            ->once();

        $this->actingAs($this->createSuperAdminUser())->post('admin/pisma', [
            'messageType' => $this->createSponsorshipMessageType()->id,
            'sponsor' => $this->createPersonData()->id,
            'cat' => $this->createCat()->id,
            'should_send_email' => true,
        ]);
    }

    public function test_does_not_send_email_on_submit_if_should_send_email_field_is_false()
    {
        SponsorshipMessageHandler::partialMock()
            ->shouldNotReceive('send');

        $this->actingAs($this->createSuperAdminUser())->post('admin/pisma', [
            'messageType' => $this->createSponsorshipMessageType()->id,
            'personData' => $this->createPersonData()->id,
            'cat' => $this->createCat()->id,
            'should_send_email' => false,
        ]);
    }

    public function test_returns_messages_sent_to_sponsor()
    {
        $sponsor = $this->createPersonData();
        $message1 = $this->createSponsorshipMessage(['sponsor_id' => $sponsor->id]);
        $message2 = $this->createSponsorshipMessage(['sponsor_id' => $sponsor->id]);

        $response = $this
            ->actingAs($this->createSuperAdminUser())
            ->get(route('admin.get_messages_sent_to_sponsor', $sponsor));

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['message_type_id' => $message1->message_type_id])
            ->assertJsonFragment(['message_type_id' => $message2->message_type_id]);
    }

    public function test_returns_parsed_template_preview()
    {
        $messageType = $this->createSponsorshipMessageType();
        $sponsor = $this->createPersonData();
        $cat = $this->createCat();

        TemplateApiClient::shouldReceive('retrieveTemplate')
            ->once()
            ->with($messageType->template_id)
            ->andReturn('template_text');

        $this->mock(MailTemplateParser::class)
            ->shouldReceive('parse')
            ->once()
            ->with('template_text', [
                'ime_botra' => $sponsor->first_name,
                'ime_muce' => $cat->name,
            ])
            ->andReturn('parsed_template');

        $response = $this
            ->actingAs($this->createSuperAdminUser())
            ->get(
                route(
                    'admin.get_parsed_template_preview',
                    ['message_type' => $messageType->id, 'sponsor' => $sponsor->id, 'cat' => $cat->id]
                )
            );

        $response
            ->assertStatus(200)
            ->assertJson(['parsedTemplate' => 'parsed_template']);
    }
}
