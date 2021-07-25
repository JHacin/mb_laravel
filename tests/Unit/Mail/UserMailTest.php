<?php

namespace Tests\Unit\Mail;

use App\Mail\Client\MailClient;
use App\Mail\UserMail;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

class UserMailTest extends TestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function test_sends_welcome_email()
    {
        $user = $this->createUser();

        $this->mock(MailClient::class)
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => $user->email,
                'subject' => 'Dobrodošli na strani Mačji boter',
                'template' => 'user_welcome',
            ]);

        $this->app->make(UserMail::class)->sendWelcomeEmail($user);
    }
}
