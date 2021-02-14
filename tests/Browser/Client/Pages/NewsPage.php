<?php

namespace Tests\Browser\Client\Pages;

class NewsPage extends Page
{

    public function url(): string
    {
        return config('routes.news');
    }
}
