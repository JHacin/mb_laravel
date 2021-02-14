<?php

namespace Tests\Browser\Client\Pages;

class RegistrationPage extends Page
{
    public function url(): string
    {
        return config('routes.register');
    }
}
