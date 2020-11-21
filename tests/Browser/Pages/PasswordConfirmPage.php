<?php

namespace Tests\Browser\Pages;

class PasswordConfirmPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return config('routes.confirm_password');
    }
}
