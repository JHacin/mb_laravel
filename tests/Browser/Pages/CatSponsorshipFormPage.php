<?php

namespace Tests\Browser\Pages;

use App\Models\Cat;
use Laravel\Dusk\Browser;

class CatSponsorshipFormPage extends Page
{
    /**
     * @var Cat
     */
    protected $cat;

    /**
     * @param Cat $cat
     */
    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return str_replace('{cat}', $this->cat->slug, config('routes.cat_sponsorship_form'));
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [];
    }
}
