<?php

namespace Tests\Unit\Services;

use App\Mail\MailClient;
use App\Services\UserMailService;
use Mockery;
use Tests\TestCase;

class UserMailServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_welcome_email()
    {
        $mailClientMock = Mockery::mock(MailClient::class);
        $user = $this->createUser();

        $mailClientMock
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => $user->email,
                'subject' => 'Dobrodošli na strani Mačji boter',
                'text' => 'Dobrodošli na spletni strani Mačji boter!',
            ]);

        $service = new UserMailService($mailClientMock);

        $service->sendWelcomeEmail($user);
    }
}
