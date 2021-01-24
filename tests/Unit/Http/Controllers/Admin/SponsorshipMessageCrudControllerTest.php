<?php

namespace Tests\Unit\Http\Controllers\Admin;

use MailTemplateParser;
use SponsorshipMessageHandler;
use TemplateApiClient;
use Tests\TestCase;

class SponsorshipMessageCrudControllerTest extends TestCase
{
    public function test_sends_email_on_submit()
    {
        SponsorshipMessageHandler::shouldReceive('send')->once();

        $this->actingAs($this->createSuperAdminUser())->post('admin/pisma', [
            'messageType' => $this->createSponsorshipMessageType()->id,
            'personData' => $this->createPersonData()->id,
            'cat' => $this->createCat()->id,
        ]);
    }

    public function test_returns_messages_sent_to_sponsor()
    {
        $sponsor = $this->createPersonData();
        $message1 = $this->createSponsorshipMessage(['person_data_id' => $sponsor->id]);
        $message2 = $this->createSponsorshipMessage(['person_data_id' => $sponsor->id]);

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

        MailTemplateParser::shouldReceive('parse')
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
