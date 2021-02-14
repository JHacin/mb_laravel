<?php

namespace Tests\Browser\Client\Pages;

class HomePage extends Page
{
    public function url(): string
    {
        return config('routes.home');
    }
}
