<?php

namespace Tests\Browser\Pages;

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
