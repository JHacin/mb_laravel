<?php

namespace Tests\Browser\Pages;

class RegistrationPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return config('routes.register');
    }
}
