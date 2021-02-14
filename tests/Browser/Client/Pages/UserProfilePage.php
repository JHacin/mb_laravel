<?php

namespace Tests\Browser\Client\Pages;

class UserProfilePage extends Page
{
    /**
     * @inheritDoc
     */
    public function url(): string
    {
        return config('routes.user_profile');
    }
}
