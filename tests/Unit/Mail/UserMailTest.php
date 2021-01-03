<?php

namespace Tests\Unit\Mail;

use MailClient;
use Tests\TestCase;
use UserMail;

class UserMailTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_welcome_email()
    {
        $user = $this->createUser();

        MailClient::shouldReceive('send')
            ->once()
            ->with([
                'to' => $user->email,
                'subject' => 'Dobrodošli na strani Mačji boter',
                'template' => 'user_welcome',
            ]);

        UserMail::sendWelcomeEmail($user);
    }
}
