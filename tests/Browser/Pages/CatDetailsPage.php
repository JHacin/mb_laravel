<?php

namespace Tests\Browser\Pages;

use App\Models\Cat;

class CatDetailsPage extends Page
{
    /**
     * @var Cat
     */
    protected Cat $cat;

    /**
     * @param Cat $cat
     */
    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return str_replace(
            '{cat}',
            $this->cat->slug,
            config('routes.cat_details')
        );
    }
}
