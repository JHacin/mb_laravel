<?php

namespace App\Mail;

use App\Models\User;
use MailClient;

class UserMail
{
    /**
     * @param \App\Models\User $user
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function sendWelcomeEmail(User $user)
    {
        MailClient::send([
            'to' => $user->email,
            'subject' => 'Dobrodošli na strani Mačji boter',
            'template' => 'user_welcome',
        ]);
    }
}
