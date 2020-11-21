<?php

namespace Tests\Browser\Pages;

class ForgotPasswordPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return config('routes.forgot_password');
    }
}
