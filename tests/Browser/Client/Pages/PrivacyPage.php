<?php

namespace Tests\Browser\Client\Pages;

class PrivacyPage extends Page
{
    public function url(): string
    {
        return config('routes.privacy');
    }
}
