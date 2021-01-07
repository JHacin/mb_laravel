<?php

namespace Tests\Browser\Pages;

class PrivacyPage extends Page
{
    public function url(): string
    {
        return config('routes.privacy');
    }
}
