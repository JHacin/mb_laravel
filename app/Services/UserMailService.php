<?php

namespace App\Services;

use App\Mail\MailClient;
use App\Models\User;

class UserMailService
{
    /**
     * @var MailClient
     */
    private MailClient $client;

    /**
     * @param MailClient $mailClient
     */
    public function __construct(MailClient $mailClient)
    {
        $this->client = $mailClient;
    }

    /**
     * @param User $user
     */
    public function sendWelcomeEmail(User $user)
    {
        $this->client->send([
            'to' => $user->email,
            'subject' => 'Dobrodošli na strani Mačji boter',
            'template' => 'user_welcome',
        ]);
    }
}
