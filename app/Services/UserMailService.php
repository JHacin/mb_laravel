<?php


namespace App\Services;


use App\Mail\UserWelcomeEmail;
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
            Mail::to($user)->send(new UserWelcomeEmail);
        } catch (Exception $e) {
            // Todo: handle exception
        }
    }
}
