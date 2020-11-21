<?php

namespace Tests\Browser\Pages;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return config('routes.home');
    }
}
