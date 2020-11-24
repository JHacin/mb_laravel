<?php

namespace Tests\Browser\Pages\Admin;

use App\Models\Cat;

class AdminCatEditPage extends Page
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
        return str_replace('{id}', $this->cat->id, $this->prefixUrl(config('routes.admin.cats_edit')));
    }
}
