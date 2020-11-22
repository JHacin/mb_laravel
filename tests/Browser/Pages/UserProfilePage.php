<?php

namespace Tests\Browser\Pages;

class UserProfilePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return config('routes.user_profile');
    }
}
