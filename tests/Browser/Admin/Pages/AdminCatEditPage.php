<?php

namespace Tests\Browser\Admin\Pages;

use App\Models\Cat;

class AdminCatEditPage extends Page
{
    protected Cat $cat;

    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    public function url(): string
    {
        return str_replace('{id}', $this->cat->id, $this->prefixUrl(config('routes.admin.cats_edit')));
    }
}
