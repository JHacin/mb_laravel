<?php

namespace Tests\Unit\Mail;

use App\Mail\MailClient;
use Mailgun\Mailgun;
use Mockery;
use Tests\TestCase;

class MailClientTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_message_with_params()
    {
        $mock = Mockery::mock(Mailgun::class);

        $params = [
            'to' => 'john.doe@example.com',
            'subject' => 'Hello',
            'text' => 'This is a message.',
        ];

        $mock
            ->shouldReceive('messages->send')
            ->once()
            ->with(
                env('MAILGUN_DOMAIN'),
                array_merge(['from' => env('MAIL_FROM_ADDRESS')], $params)
            );

        (new MailClient($mock))->send($params);
    }
}
