<?php

namespace Tests\Browser\Pages;

use App\Models\Cat;

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
}
