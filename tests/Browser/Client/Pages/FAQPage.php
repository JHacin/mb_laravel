<?php

namespace Tests\Browser\Client\Pages;

class FAQPage extends Page
{
    public function url(): string
    {
        return config('routes.faq');
    }
}
