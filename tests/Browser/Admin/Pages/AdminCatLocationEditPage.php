<?php

namespace Tests\Browser\Admin\Pages;

use App\Models\CatLocation;

class AdminCatLocationEditPage extends Page
{
    protected ?CatLocation $catLocation = null;

    public function __construct(CatLocation $catLocation)
    {
        $this->catLocation = $catLocation;
    }

    public function url(): string
    {
        return str_replace('{id}', $this->catLocation->id, $this->prefixUrl(config('routes.admin.cat_locations_edit')));
    }
}
