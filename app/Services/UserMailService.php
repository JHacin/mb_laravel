<?php


namespace App\Services;


use App\Mail\UserWelcomeEmail;
use App\Models\User;
use Mail;

class UserMailService
{
    /**
     * @param User $user
     */
    public static function sendWelcomeEMail(User $user)
    {
        Mail::to($user)->send(new UserWelcomeEmail);
    }
}
