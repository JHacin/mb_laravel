<?php

namespace Tests\Browser\Pages;

class NewsPage extends Page
{

    public function url(): string
    {
        return config('routes.news');
    }
}
