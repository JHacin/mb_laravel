<?php

namespace Tests\Browser\Pages;

class ResetPasswordPage extends Page
{
    private string $token;
    private string $email;

    public function __construct(string $token, string $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function url(): string
    {
        return str_replace('{token}', $this->token, config('routes.reset_password_form')) . '?email=' . $this->email;
    }
}
