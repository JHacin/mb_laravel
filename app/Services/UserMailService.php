<?php

namespace App\Services;

use App\Mail\UserWelcomeMail;
use App\Models\User;
use Exception;
use Mail;

class UserMailService extends MailService
{
    /**
     * @param User $user
     */
    public function sendWelcomeEMail(User $user)
    {
        try {
            Mail::to($user)->send(new UserWelcomeMail);
        } catch (Exception $e) {
            $this->logException($e);
        }
    }
}
