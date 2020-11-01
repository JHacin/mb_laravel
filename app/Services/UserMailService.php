<?php

namespace App\Services;

use App\Mail\UserWelcomeMail;
use App\Models\User;
use Exception;
use Mail;

class UserMailService
{
    /**
     * @param User $user
     */
    public static function sendWelcomeEMail(User $user)
    {
        try {
            Mail::to($user)->send(new UserWelcomeMail);
        } catch (Exception $e) {
            // Todo: handle exception
        }
    }
}
