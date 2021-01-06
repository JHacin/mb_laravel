<?php

namespace Tests\Browser\Pages;

class FAQPage extends Page
{
    public function url(): string
    {
        return config('routes.faq');
    }
}
