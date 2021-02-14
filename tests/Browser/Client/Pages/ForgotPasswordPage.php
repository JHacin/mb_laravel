<?php

namespace Tests\Browser\Client\Pages;

class ForgotPasswordPage extends Page
{
    public function url(): string
    {
        return config('routes.forgot_password');
    }
}
